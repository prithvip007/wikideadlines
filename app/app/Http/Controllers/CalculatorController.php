<?php

namespace App\Http\Controllers;

use App\Models\Calculation\Calculation;
use App\Models\DeliveryMethod;
use App\Models\DocumentType;
use App\Models\County;
use App\Models\Request as UserRequest;
use App\Models\DeadlineThumb;
use App\Models\EarliestHearingDate;
use App\Models\State;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ICS;
use App\Models\Interviews\RuleInterview;
use App\Models\Interviews\DocumentInterview;
use App\Models\Interviews\JurisdictionInterview;
use App\Models\StripeProduct;
use Spatie\GoogleCalendar\src\Event;


class CalculatorController extends Controller
{

    // public function store(Request $request){
    //     $startTime = Carborn::parse($request->input('meeting_date').' '. $request->input('meeting_time'));
    //     $endTime = (clone $startTime)->addhour();
    // }

    public function index(Request $request)
    {
        // TODO: remove
        $casename = Calculation::orderBy('id', 'DESC')->get();
        if ($request->session()->has('beta-tester')) {
            return redirect(route('beta-test', $request->query()));
        }

        $states = State::orderBy('name', 'asc')->get();
        $delivery_methods = DeliveryMethod::orderBy('order', 'asc')->get();
        $document_types = DocumentType::orderBy('name', 'asc')->with('dateQuestions.dateQuestionType')->get();

        $user = Auth::guard()->user();

        if ($user) {
            $canCalculate = $user->subscribed() || $user->free_calculations > 0;
        } else {
            // unauthenticated users can calculate as they will be redirected to login page
            $canCalculate = true;
        }

        $document_types->map(function ($document_type) {
            $document_type->append('delivery_method_ids');
            return $document_type;
        });

        $documentInterview = new DocumentInterview();
        $ruleInterview = new RuleInterview();
        $jurisdictionInterview = new JurisdictionInterview();

        $documentElements = $documentInterview->get();
        $deadlineRuleElements = $ruleInterview->get();
        $jurisdictionElements = $jurisdictionInterview->get();

        $documentRequestId = (int) $request->query('documentRequestId');

        $documentRequest = UserRequest::where('type', 'document_type')->find($documentRequestId);

        $calculation = null;

        if ($request->query('case_name') && $canCalculate) {
            $calculation = Calculation::select('case_name', 'id', 'hearing_courthouse', 'hearing_courtroom', 'county_id', 'state_id')
                ->where('case_name',  $request->query('case_name'))
                ->where('user_id', Auth::user()->id)
                ->latest()
                ->first();
        }

        return view('calculator.index', compact('states', 'delivery_methods', 'calculation', 'document_types', 'documentElements', 'deadlineRuleElements', 'jurisdictionElements', 'canCalculate', 'documentRequest','casename'));
    }

    // TODO: remove
    public function indexBeta(Request $request)
    {
        $states = State::orderBy('name', 'asc')->get();
        $delivery_methods = DeliveryMethod::orderBy('order', 'asc')->get();
        $document_types = DocumentType::orderBy('name', 'asc')->with('dateQuestions.dateQuestionType')->get();

        $user = Auth::guard()->user();

        if ($user) {
            $canCalculate = $user->subscribed() || $user->free_calculations > 0;
        } else {
            // unauthenticated users can calculate as they will be redirected to login page
            $canCalculate = true;
        }

        $document_types->map(function ($document_type) {
            $document_type->append('delivery_method_ids');
            return $document_type;
        });

        $documentInterview = new DocumentInterview();
        $ruleInterview = new RuleInterview();
        $jurisdictionInterview = new JurisdictionInterview();

        $documentElements = $documentInterview->get();
        $deadlineRuleElements = $ruleInterview->get();
        $jurisdictionElements = $jurisdictionInterview->get();

        $documentRequestId = (int) $request->query('documentRequestId');

        $documentRequest = UserRequest::where('type', 'document_type')->find($documentRequestId);

        $request->session()->put('beta-tester', true);

        $calculation = null;

        if ($request->query('case_name') && $canCalculate) {
            $calculation = Calculation::select('id', 'case_name', 'hearing_courthouse', 'hearing_courtroom', 'county_id', 'state_id')
                ->where('case_name',  $request->query('case_name'))
                ->where('user_id', Auth::user()->id)
                ->latest()
                ->first();
        }

        return view('calculator.indexBeta', compact(
            'states',
            'calculation',
            'delivery_methods',
            'document_types',
            'documentElements',
            'deadlineRuleElements',
            'jurisdictionElements',
            'canCalculate',
            'documentRequest'
        ));
    }

    public function calculate(Request $request)
    {
                // =================
        // $event = new Calculation;
       
        // $event->name = "An Event Added";
        // $event->description = 'Event description';
        // $event->startDateTime = Carbon\Carbon::now();
        // $event->endDateTime = Carbon\Carbon::now()->addHour();
        
        // $event->save();
       
        $events = Calculation::orderBy('id', 'DESC')->get();

        // get the id of the first upcoming event in the calendar.
     
            Calculation::create([
                    'name' =>$events->case_name 
                    
                     
                 ]);
        // dd($events);
        echo "<pre>";
        print_r ($events);
        die;

        // Calculation::find($casename);


                // ================
       $document_type_id = (int) $request->input('document_type_id');
        $state_id = (int) $request->input('state_id');
        $county_id = (int) $request->input('county_id');

        $document_type = DocumentType::with('dateQuestions')->findOrFail($document_type_id);
        $state = State::findOrFail($state_id);
        $county = County::where('state_id', $state_id)->findOrFail($county_id);

        $this->validate($request, ['type' => 'required|in:document_to_send,document_received']);
        
        if ($document_type->requires_delivery_method) {
            $delivery_method = DeliveryMethod::find((int)$request->input('delivery_method_id'));
        }

        $date_questions = $document_type->dateQuestions()->get();

        $rules = [
            'case_name' => 'nullable|max:500'
        ];

        foreach ($date_questions as $question) {
            $required = $question->required && $request->input('type') === 'document_received' ? 'required' : 'nullable';
            $rules["date_question_$question->id"] = "{$required}|date";

            if ($question->reference_key === 'dps' && $delivery_method && $delivery_method->reference_key === 'personal_service') {
                $rules["date_question_$question->id"] = 'nullable|date';
            }
        }

        foreach (Calculation::getActiveEvents() as $deadlineKey) {
            if (!$document_type->{"requires_$deadlineKey"}) {
                continue;
            }

            if ($deadlineKey === 'dps' && $delivery_method &&  $delivery_method->reference_key === 'personal_service') {
                $rules[$deadlineKey] = 'nullable|date';
            } elseif (
                $request->input('type') === 'document_to_send' ||
                $deadlineKey === 'ftds' ||
                $deadlineKey === 'td'
            ) {
                $rules[$deadlineKey] = 'nullable|date';
            } else {
                $rules[$deadlineKey] = 'required|date';
            }
        }

        if ($document_type->ask_hearing_courthouse) {
            $rules['hearing_courthouse'] = 'nullable|string|max:50';
        }

        if ($document_type->ask_hearing_courtroom) {
            $rules['hearing_courtroom'] = 'nullable|string|max:50';
        }

        if ($document_type->requires_same_judge) {
            $rules['same_judge'] = 'required|in:1,0';
        }

        if (isset($delivery_method)) {
            $delivery_areas = [0];

            if ($delivery_method->has_outside_country_days) {
                $delivery_areas[] = 1;
            }

            if ($delivery_method->has_outside_state_days) {
                $delivery_areas[] = 2;
            }

            $rules['delivery_area'] = 'nullable|in:' . implode(',', $delivery_areas);
        }

        $this->validate($request, $rules);

        $calculation = new Calculation();

        $calculation->type = $request->input('type');

        $calculation->case_name = mb_strlen((string)$request->input('case_name')) > 0 ? (string)$request->input('case_name') : null;
        $calculation->document_type()->associate($document_type);

        if (isset($delivery_method)) {
            $calculation->delivery_method()->associate($delivery_method);
        }
        $calculation->state()->associate($state);
        $calculation->county()->associate($county);

        foreach (Calculation::getActiveEvents() as $deadlineKey) {
            $calculation->{$deadlineKey} = $request->input($deadlineKey) ? Carbon::parse(
                Carbon::parse($request->input($deadlineKey))->format('Y-m-d H:i:s'),
                $state->timezone
            )->setTimezone(config('app.timezone')) : null;
        }

        if (isset($delivery_method)) {
            $calculation->delivery_area = (int)$request->input('delivery_area');
        }

        if ($document_type->ask_hearing_courthouse && $request->has('hearing_courthouse')) {
            $calculation->hearing_courthouse = $request->input('hearing_courthouse');
        }

        if ($document_type->ask_hearing_courtroom && $request->has('hearing_courtroom')) {
            $calculation->hearing_courtroom = $request->input('hearing_courtroom');
        }

        if ($document_type->requires_same_judge) {
            $calculation->same_judge = (bool)$request->input('same_judge');
        }

        $authedUserId = Auth::id();
        $calculation->user_id = $authedUserId;

        if (
            $request->type === 'document_to_send'
        ) {
            // TODO: it should handle date questions as well
            foreach (Calculation::$deliveryEvents as $deadlineKey) {
                $hd = $request->input('hd');

                if (!$hd) {
                    $hdQuestion = $date_questions->first(function ($question) {
                        return $question->reference_key === 'hd';
                    });


                    if ($hdQuestion) {
                        $hd = $request->input("date_question_$hdQuestion->id") ?? $hd;
                    }
                }

                $calculation->{$deadlineKey} = $hd ? Carbon::parse(
                    Carbon::parse($hd)->format('Y-m-d H:i:s'),
                    $state->timezone
                )->setTimezone(config('app.timezone')) : null;
            }
        }

        $calculation->calculate($request->input('type'));

        $user = Auth::guard()->user();

        if (!$user->subscribed() && $user->free_calculations > 0) {
            $user->free_calculations -= 1;
            $user->save();
        } elseif (!$user->subscribed()) {
            $calculation->accessable = false;
        }

        $calculation->save();

        /**
         * we calculate EarliestHearingDate only for date questions because 
         * dealined with add_to: hd can't have optional question 
         */
        foreach ($date_questions as $question) {
            $question_input_value = $request->input("date_question_$question->id");

            if (!$question_input_value) {
                if (
                    $question->reference_key === 'earliest_hd_date' &&
                    $document_type->isMotion()
                ) {
                    $deliveryMethods = DeliveryMethod::all();

                    foreach ($deliveryMethods as $deliveryMethod) {
                        $earliestHearingDate = new EarliestHearingDate();

                        $earliestHearingDate->delivery_method_id = $deliveryMethod->id;
                        $earliestHearingDate->calculation_id = $calculation->id;

                        $earliestHearingDate->calculate();

                        $earliestHearingDate->save();
                    }
                }

                continue;
            }

            $date_value = Carbon::parse(Carbon::parse($question_input_value)->format('Y-m-d H:i:s'), $state->timezone)->setTimezone(config('app.timezone'));
            $date_answers[] = [
                'value' => $date_value,
                'date_question_id' => $question->id,
                'calculation_id' => $calculation->id
            ];
        }

        if (isset($date_answers)) {
            $calculation->dateAnswers()->createMany($date_answers);
        }

        if ($calculation->accessable === false) {
            $session = $user->createCheckoutForSearchProduct([
                'calculation_id' => $calculation->id
            ], route('calculation', ['key' => $calculation->key]), route('payment.fail'));

            return redirect($session->url);
        }

        return redirect(route('calculation', ['key' => $calculation->key]))->with('new', true);
    }

    public function calculation(string $key)
    {
        $calculation = Calculation::findByKeyOrFail($key);

        $ruleInterview = new RuleInterview();

        $documentInterview = new DocumentInterview();

        $documentElements = $documentInterview->getFilledFromCalculation($calculation);

        $autoFilledInterviews = $ruleInterview->getFilledFromCalculation($calculation, null);

        $interviewElements = json_encode($ruleInterview->getFilledWithDocumentTypeName($calculation->getSnapshotInstance()->document_type->name));

        $user = Auth::guard()->user();

        $hasSubscription = $user === null ? false : $user->subscribed();

        // if the calculation was created by unauthenticated user
        // we assign it to the first user who accessed it
        // because "sync to calendar" is available only to users with subscription  
        if ($user && !$calculation->user_id) {
            $calculation->user_id = $user->id;
            $calculation->save();
        }

        $eventsWithDateTimeType = ['hd', 'exph', 'tasd', 'tdreq', 'ftds', 'afhd', 'td'];

        $calculationDates = array_reduce(Calculation::$events, function($carry, $event) use ($eventsWithDateTimeType, $calculation) {
            if (in_array($event, $eventsWithDateTimeType) === true) {
                $carry[$event] = [
                    'icon' => 'fa-clock-o',
                    'type' => 'datetime',
                    'question' => __("events.{$event}.{$calculation->type}"),
                    'value' => null
                ];
            } else {
                $carry[$event] = [
                    'icon' => 'fa-calendar',
                    'type' => 'date',
                    'question' => __("events.{$event}.{$calculation->type}"),
                    'value' => null
                ];
            }

            return $carry;
        }, []);

        foreach ($calculationDates as $key => &$calculationDate) {
            if (!$calculation->{$key}) {
                continue;
            }

            $calculationDate['value'] = $calculation->{$key}->copy();


            $calculationDate['value']->setTimezone($calculation->state->timezone);
        }

        $deadlines = collect($calculation->deadlines);

        $deadlines = $deadlines->sortBy('date', SORT_REGULAR, false);

        $calculationView = [
            'id' => $calculation->id,
            'deliveryArea' => $calculation->delivery_area,
            'type' => $calculation->type,
        ];

        $deadlinesView = [];

        if ($deadlines->count() > 0) {
            foreach ($deadlines as $key => $deadline)
            {
                $thumbActive = $user ? !!DeadlineThumb::where([
                    'user_id' => $user->id,
                    'deadline_id' => $deadline->snapshot->id,
                    'calculation_id' => $calculation->id
                ])->first() : false;
    
                $deadlinesView[] = [
                    'id' => $deadline->snapshot->id,
                    'title' => $deadline->snapshot->title,
                    'name' => $deadline->snapshot->name,
                    'visibilityScopes' => $deadline->snapshot->visibility_scopes || [],
                    'bestPractices' => $deadline->snapshot->best_practices,
                    'isDPSLate' => $calculation->isDPSLate($deadline),
                    'isDatePast' => $deadline->date->isPast(),
                    'checkDpsPreciseness' => $deadline->checkDpsPreciseness(),
                    'dateFormatted' => $deadline->date->format('l, F j, Y'),
                    'interviewData' => isset($autoFilledInterviews[$deadline->snapshot->id]) ? $autoFilledInterviews[$deadline->snapshot->id] : null,
                    'thumbsCount' => DeadlineThumb::getHistoricalCount($deadline->snapshot->id, $calculation->id),
                    'thumbActive' => $thumbActive
                ];
            }
        } else {
            foreach ($calculation->getSnapshotInstance()->deadlines as $deadline)
            {
                $thumbActive = $user ? !!DeadlineThumb::where([
                    'user_id' => $user->id,
                    'deadline_id' => $deadline->id,
                    'calculation_id' => $calculation->id
                ])->first() : false;
    
                $deadlinesView[] = [
                    'id' => $deadline->id,
                    'name' => $deadline->name,
                    'title' => $deadline->title,
                    'bestPractices' => $deadline->best_practices,
                    'visibilityScopes' => $deadline->visibility_scopes || [],
                    'isDPSLate' => false,
                    'isDatePast' => false,
                    'checkDpsPreciseness' => false,
                    'dateFormatted' => '',
                    'interviewData' => isset($autoFilledInterviews[$deadline->id]) ? $autoFilledInterviews[$deadline->id] : null,
                    'thumbsCount' => DeadlineThumb::getHistoricalCount($deadline->id, $calculation->id),
                    'thumbActive' => $thumbActive
                ];
            }
        }

        $today = Carbon::now()->format('Y-m-d');
        $documentName = $calculation->getSnapshotInstance()->document_type->name;
        $caseName = $calculation->case_name;

        $printTitle = "$caseName - $documentName - $today - WikiDeadlines";

        $deliveryMethodId = $calculation->getSnapshotInstance()->delivery_method ? $calculation->getSnapshotInstance()->delivery_method->id : null;
        $documentDeliveryMethods = $calculation->getSnapshotInstance()->documentDeliveryMethods;

        $isCorrectDeliveryMethod = ($deliveryMethodId === null || $documentDeliveryMethods === null) ? true : collect($documentDeliveryMethods)->search(function ($item) use ($deliveryMethodId) {
            return $item['id'] === $deliveryMethodId;
        }) !== false;

        return view('calculator.calculation', compact(
            'printTitle',
            'hasSubscription',
            'deadlinesView',
            'calculationView',
            'isCorrectDeliveryMethod',
            'calculation',
            'deadlines',
            'interviewElements',
            'calculationDates',
            'documentElements'
        ));
    }

    public function generateIcalFile(string $key, Request $request)
    {
        $id = $request->query('id');

        if ($id === null) {
            $deadlineIds = [];
        } else if (is_string($id)) {
            $deadlineIds[] = (int) $id;
        } else {
            $deadlineIds = array_map('intval', $request->query('id'));
        }

        $calculation = Calculation::findByKeyOrFail($key);

        foreach($calculation->deadlines as $deadline) {
            if (
                !empty($deadlineIds) &&
                in_array($deadline->snapshot->id, $deadlineIds) === false
            ) {
                continue;
            }

            $data[] = [
                'summary' => $calculation->getSnapshotInstance()->document_type->name . ' - deadline',
                'description' => $deadline->snapshot->name,
                'dtstart' => $deadline->date,
                'dtend' => $deadline->date,
                'url' => route('calculation', ['key' => $calculation->key])
            ];
        }

        $title = $calculation->case_name === null
            ? $calculation->getSnapshotInstance()->document_type->name . ' document type deadlines - Wikideadlines'
            : $calculation->case_name . ' - Wikideadlines';

        $ics = new ICS($data, $title, 'Ymd');

        $contents = $ics->toString();
        $filename = 'calendar.ics';

        return response()->streamDownload(function () use ($contents) {
            echo $contents;
        }, $filename);
    }

    public function getCaseNames(Request $request)
    {
        $paginator = Calculation::
            select('case_name')
            ->groupby('case_name')
           ->distinct()
           ->where('case_name', 'ilike', '%' . $request->query->get('search') . '%')
        //    ->where('user_id', Auth::user()->id)
           ->paginate(20);

        $results = $paginator->map(function ($calculation) use ($request) {
            $last = Calculation::select('id', 'hearing_courthouse', 'hearing_courtroom', 'county_id', 'state_id')
                ->where('case_name',  $calculation->case_name)
                ->where('user_id', Auth::user()->id)
                ->latest()
                ->first();
        
            return [
                // select2 requires id, bu in our case it's a case's name
                'id' => $calculation->case_name,
                'text' => $calculation->case_name,
                'hearing_courthouse' => $last->hearing_courthouse ?? null,
                'hearing_courtroom' => $last->hearing_courtroom ?? null,
                'county_id' => $last->county_id ?? null,
                'state_id' => $last->state_id ?? null,
            ];
        });

        // such response structure is required by select2
        // https://select2.org/data-sources/formats
        return response()->json([
            'results' => $results,
            "pagination" => [
                'more' => $paginator->hasPages()
            ]
        ]);
    }

    public function getLastActualDataForCaseName(Request $request)
    {
        $calculation = Calculation::select('id', 'hearing_courthouse', 'hearing_courtroom', 'county_id', 'state_id')
            ->where('case_name', $request->query->get('caseName'))
            ->where('user_id', Auth::user()->id)
            ->latest()
            ->first();

        return response()->json([
            'data' => $calculation ? [
                'hearing_courthouse' => $calculation->hearing_courthouse,
                'hearing_courtroom' => $calculation->hearing_courtroom ,
                'county_id' => $calculation->county_id,
                'state_id' => $calculation->state_id
            ] : null
        ]);
    }

    public function updateCountyForCaseName(Request $request)
    {
        $rules = [
            'county_id' => 'required|exists:App\Models\County,id',
            'case_name' => 'nullable|string',
        ];

        $this->validate($request, $rules);

        Calculation::where('case_name', $request->case_name)
            ->where('user_id', Auth::user()->id)
            ->update(['county_id' => $request->county_id]);
    }

    public function getCaluclationsByCaseName(Request $request)
    {
        $name = $request->query->get('caseName');

        $paginator = Calculation::select(
            'key',
            "snapshot->document_type->name as document_name",
            'created_at'
        )
            ->where('case_name', $name)
            ->latest()
            ->paginate(20);

        $results = $paginator->map(function ($item) {
            return [
                'document' => $item->document_name,
                'created_at' => $item->created_at->format('l, F j, Y G:i A'),
                'url' => route('calculation', ['key' => $item->key])
            ];
        });

        return response()->json([
            'results' => $results,
            "pagination" => [
                'more' => $paginator->hasMorePages()
            ]
        ]);
    }
}
