<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\NewUserRequest;
use App\Mail\AddMoreDeadlines;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use App\Models\DocumentType;
use App\Models\User;

class RequestsController extends Controller
{
    public function send(Request $request)
    {

 // TODO: write custom validation rule
        $rules = [
            'type' => 'required|in:edit_document_type,document_type,add_deadline,edit_deadline,feedback,jurisdiction',
            'data' => 'required|array|between:1,50'
        ];

        if (
            $request->input('type') === 'document_type' ||
            $request->input('type') === 'edit_document_type' ||
            $request->input('type') === 'jurisdiction' ||
            $request->input('type') === 'add_deadline' ||
            $request->input('type') === 'edit_deadline'
        ) {
            $rules['data.email'] = 'required|email';
            $rules['data.deadlines'] = 'array:title,value,meta|between:1,50';
            $rules['data.deadlines.*.title'] = 'string|max:2000';
            $rules['data.deadlines.*.value'] = 'string|nullable|max:2000';
            $rules['data.deadlines.*.meta'] = 'array:key';
            $rules['data.deadlines.*.meta.key'] = 'string|required|max:100';

            if ($request->input('type') === 'edit_deadline') {
                $rules['data.deadline_id'] = 'required|exists:App\Models\Deadline,id';
            }

            if (
                $request->input('type') === 'edit_deadline' ||
                $request->input('type') === 'add_deadline'
            ) {
                $rules['data.calculation_id'] = 'nullable|exists:App\Models\Calculation\Calculation,id';
            }
        }  elseif ($request->input('type') === 'feedback') {
            $rules['data.text'] = 'required_without:data.email|nullable|string|max:2000';
            $rules['data.email'] = 'required_without:data.text|nullable|email|max:100';
        }

        if (
            $request->input('type') === 'add_deadline'
        ) {
            $rules['data.request_id'] = [
                'required_without:data.document_id',
                Rule::exists('requests', 'id')->where(function ($query) {
                    return $query->where('type', 'document_type');
                }),
            ];

            $rules['data.document_id'] = ['required_without:data.request_id','exists:App\Models\DocumentType,id'];
        }

        $this->validate($request, $rules);

        if (
            $request->input('type') === 'document_type' || 
            $request->input('type') === 'edit_document_type'
        ) {
            foreach ($request->input('data.deadlines') as $key => $deadline) {
               
                if ($deadline['meta']['key'] === 'keywords') {
                    $validator = Validator::make($deadline, [
                        'value' => 'nullable|regex:/^[\pL\s\-]',
                    ]);
                   
                    if ($validator->fails()) {
                        throw ValidationException::withMessages([
                            "data.deadlines.{$key}.value" => 'Unique keywords to help a user find this document '
                        ]);
                    }
                }

                // TODO: Validate referenceKeys against existing delivery methods
                if ($deadline['meta']['key'] === 'delivery-methods-list') {
                    $validator = Validator::make($deadline, [
                        'meta.item.referenceKeys' => 'required|array',
                        'meta.item.referenceKeys.*'  => "string|nullable|distinct",
                    ]);

                    $validator->validate();
                }
            }
        }

        if (
            $request->input('type') === 'edit_deadline' ||
            $request->input('type') === 'add_deadline'
        ) {
            foreach ($request->input('data.deadlines') as $key => $deadline) {
                // TODO: Validate referenceKeys against existing delivery methods
                if ($deadline['meta']['key'] === 'triggering-event') {
                    $validator = Validator::make($deadline, [
                        'meta.item.referenceKey' => 'sometimes|required|string|nullable',
                    ]);

                    $validator->validate();
                }
            
            }
        }

        if ($request->input('type') === 'document_type') {
            $savedUserRequest = \App\Models\Request::create([
                'type' => $request->input('type'),
                'data' => [
                    'name' => $request->input('data.name'),
                    'email' => $request->input('data.email'),
                    'deadlines' => $request->input('data.deadlines')
                ]
            ]);
        } elseif ($request->input('type') === 'edit_document_type') {
            $savedUserRequest = \App\Models\Request::create([
                'type' => $request->input('type'),
                'data' => [
                    'name' => $request->input('data.name'),
                    'email' => $request->input('data.email'),
                    'deadlines' => $request->input('data.deadlines'),
                    'document_id' => $request->input('data.document_id')
                ]
            ]);
        } elseif ($request->input('type') === 'jurisdiction') {
            $savedUserRequest = \App\Models\Request::create([
                'type' => $request->input('type'),
                'data' => [
                    'name' => $request->input('data.name'),
                    'email' => $request->input('data.email'),
                    'deadlines' => $request->input('data.deadlines')
                ]
            ]);
        }  elseif (
            $request->input('type') === 'add_deadline'
        ) {
            $savedUserRequest = \App\Models\Request::create([
                'type' => $request->input('type'),
                'data' => [
                    'email' => $request->input('data.email'),
                    'deadlines' => $request->input('data.deadlines'),
                    'calculation_id' => $request->input('data.calculation_id'),
                    'request_id' => $request->input('data.request_id'),
                    'document_id' => $request->input('data.document_id'),
                ]
            ]);
        } elseif ($request->input('type') === 'edit_deadline') {
            $savedUserRequest = \App\Models\Request::create([
                'type' => $request->input('type'),
                'data' => [
                    'email' => $request->input('data.email'),
                    'deadlines' => $request->input('data.deadlines'),
                    'calculation_id' => $request->input('data.calculation_id'),
                    'deadline_id' => $request->input('data.deadline_id')
                ]
            ]);
        } elseif ($request->input('type') === 'feedback') {
            $data = [];
            foreach ($request->input('data') as $field => $v){
                $data[$field] = $v;
            }
            $savedUserRequest = \App\Models\Request::create([
                'type' => $request->input('type'),
                'data' => $data,
            ]);
        }



        User::whereRoleIs('admin')->get()->each(function ($user) use ($savedUserRequest) {
            if (sizeof($user->notification_emails) === 0) {
                return;
            }

            $NewUserRequestMail = new NewUserRequest($savedUserRequest, $user);
            Mail::to($user->notification_emails)->queue($NewUserRequestMail); 
        }, []);


        if ($savedUserRequest->type === 'document_type') {

            $addMoreDeadlinesMail = new AddMoreDeadlines(Auth::user(), $savedUserRequest);
            Mail::to($savedUserRequest->data['email'])
                ->later(
                    now()->addMinutes(config('app.add_deadlines_notification.minutes')),
                    $addMoreDeadlinesMail
                );
        }

        return response()->json([
            'data' => [
                'id' => $savedUserRequest->id
            ]
        ]);
    }
}
