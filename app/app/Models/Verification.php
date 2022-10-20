<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Mail\EmailVerificationCode;
use Illuminate\Support\Facades\Mail;

class Verification extends Model
{
    static public function verify(string $identifier, string $code): bool
    {        
        $result = self::whereRaw("CURRENT_TIMESTAMP - created_at <= '15 minutes'::interval")
            ->where('verified_at', '=', null)
            ->where('identifier', '=', $identifier)
            ->where('code', '=', $code)
            ->first();

        if ($result === null) {
            return false;
        }

        $result->verified_at = now();

        $result->save();

        return true;
    }

    static public function startVerification(string $identifier, $type = 'email'): self
    {
        $code = self::generateCode();

        $verification = new Verification();

        $verification->identifier = $identifier;
        $verification->code = $code;

        $verification->save();

        if ($type === 'email') {
            $email = new EmailVerificationCode($code);
            Mail::to($identifier)->queue($email);
        }

        return $verification;
    }

    static private function generateCode($digits = 6): string
    {
        $max = self::getMaxDecimalInt($digits);

        $number = rand(0, $max);

        $padString = '0';

        $code = str_pad((string) $number, $digits, $padString);

        return $code;
    }

    static private function getMaxDecimalInt(int $numberOfDigits, $base = 10): int
    {
        $largestDigit = $base - 1;
        $maxInt = 0;

        for ($power = 0; $power < $numberOfDigits; $power++) {
            $maxInt += $largestDigit * pow($base, $power);
        }

        return $maxInt;
    }
}
