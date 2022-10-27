<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(\Seeds\StateSeeder::class);
        $this->call(\Seeds\DeliveryMethodSeeder::class);
        $this->call(\Seeds\DateQuestionsSeeder::class);

        // $this->call(\Seeds\Deadlines\AcknowledgmentOfReceiptSeeder::class);
        // $this->call(\Seeds\Deadlines\Answer::class);
        $this->call(\Seeds\Deadlines\AntiSLAAPMotion::class);
        $this->call(\Seeds\Deadlines\NoticeOfArbitrationDate::class);
        $this->call(\Seeds\Deadlines\CCPSection998OfferToCompromise::class);
        $this->call(\Seeds\Deadlines\ComplaintAgainstNonPublicEntitySeeder::class);
        $this->call(\Seeds\Deadlines\ComplaintAgainstPublicEntitySeeder::class);
        $this->call(\Seeds\Deadlines\CrossComplaintAgainstNonPublicEntitySeeder::class);
        $this->call(\Seeds\Deadlines\Demurrer::class);
        $this->call(\Seeds\Deadlines\Discovery::class);
        // $this->call(\Seeds\Deadlines\EntryOfJudgment::class);
        // $this->call(\Seeds\Deadlines\MotionForReconsideration::class);
        $this->call(\Seeds\Deadlines\MotionForSanctions::class);
        $this->call(\Seeds\Deadlines\MotionForSummaryJudgment::class);
        $this->call(\Seeds\Deadlines\MotionToCompelDiscoveryResponses::class);
        $this->call(\Seeds\Deadlines\MotionToContinueHearing::class);
        $this->call(\Seeds\Deadlines\NoticeOfApplicationAndHearingForWritOfAttachmentUnderSection484040::class);
        $this->call(\Seeds\Deadlines\MotionToContinueHearingExParteApplication::class);
        $this->call(\Seeds\Deadlines\MotionToStrikeCosts::class);
        $this->call(\Seeds\Deadlines\MotionToExpungeNoticeOfPendencyOfActionPursuantToSection40530::class);
        $this->call(\Seeds\Deadlines\MotionToSetAsideDefaultAndForLeaveToDefendPursuantToSection4735::class);
        $this->call(\Seeds\Deadlines\MotionToSetAsideDefaultAndForLeaveToDefendPursuantToSection5855::class);
        $this->call(\Seeds\Deadlines\MotionToStrikeSeeder::class);
        $this->call(\Seeds\Deadlines\MotionToTaxCosts::class);
        $this->call(\Seeds\Deadlines\NoticeOfCaseManagementConferenceHearing::class);
        $this->call(\Seeds\Deadlines\NoticeOfChangeOfAddressOfAnyCounselOrUnrepresentedInProPerParty::class);
        $this->call(\Seeds\Deadlines\NoticeOfDepositionOfExpert::class);
        $this->call(\Seeds\Deadlines\NoticeOfEntryOfDefault::class);
        $this->call(\Seeds\Deadlines\NoticeOfHearingOfApplicationForReliefPursuanToSection9466OfTheGovernmentCode::class);
        $this->call(\Seeds\Deadlines\NoticeOfEntryOfJudgment::class);
        $this->call(\Seeds\Deadlines\NoticeOfEntryOfOrder::class);
        $this->call(\Seeds\Deadlines\ReceiptOfSignedAcknowledgementOfReceiptOfSummons::class);
        $this->call(\Seeds\Deadlines\NoticeOfTrustAdministration::class);
        // $this->call(\Seeds\Deadlines\NoticeOfJudgeAssignedAfterComplaintFiledOrDatePartyAppeared::class);
        $this->call(\Seeds\Deadlines\NoticeOfMotionForSanctionsBeforeFiledWithTheCourt::class);
        $this->call(\Seeds\Deadlines\NoticeOfIntentionToMoveForNewTrial::class);
        $this->call(\Seeds\Deadlines\ResponseToFormInterrogatories::class);
        $this->call(\Seeds\Deadlines\ResponseToRequestsForAdmissions::class);
        $this->call(\Seeds\Deadlines\ResponseToRequestsForProduction::class);
        $this->call(\Seeds\Deadlines\ResponseToSpecialInterrogatories::class);
        // $this->call(\Seeds\Deadlines\WritOfMandateAfterMotionForDeterminationOfGoodFaithSettlementPursuantToSection8776::class);
        $this->call(\Seeds\Deadlines\MotionForAnOrderToAttendDepositionMoreThan150MilesFromDeponentsResidencePursuantToSection2025260::class);
        $this->call(\Seeds\Deadlines\MotionForExtensionOfTimeToFileResponsivePleading::class);
        $this->call(\Seeds\Deadlines\TrialSettingOrder::class);
        $this->call(\Seeds\Deadlines\MotionForJudgmentOnThePleadings::class);
        $this->call(\Seeds\Deadlines\MotionForNewTrial::class);
        $this->call(\Seeds\Deadlines\CaseManagementConferenceMinuteOrder::class);
        $this->call(\Seeds\Deadlines\SanctionsDemand1287Seeder::class);
        $this->call(\Seeds\Deadlines\DemandForExchangeOfExpertWitnesses::class);
        $this->call(\Seeds\Deadlines\MotionToLimine::class);
        $this->call(\Seeds\Deadlines\MotionToAmendJudgment::class);
        $this->call(\Seeds\Deadlines\AnswerPersonallyServed::class);
        $this->call(\Seeds\Deadlines\MotionForDeterminationOfGoodFaithSettlementPursuantToSection8776::class);
        $this->call(\Seeds\Deadlines\MotionForSummaryAdjudication::class);
        $this->call(\Seeds\Deadlines\MotionForOrderShorteningTimeToServeMotion::class);
        // $this->call(\Seeds\Deadlines\ChangeOfAddressOfAnyCounselOrUnrepresentedInProPerParty::class);
        //$this->call(\Seeds\Deadlines\MotionToVacateJudgmentCCP663aOpposition::class);
        $this->call(\Seeds\Deadlines\MotionToVacateJudgmentCCP663aFileNoticeOfIntent::class);
        $this->call(\Seeds\Deadlines\MemorandumOfCosts::class);
        $this->call(\Seeds\Deadlines\ExParteMotion::class);
        $this->call(\Seeds\Deadlines\ArbitrationAward::class);
        $this->call(\Seeds\Deadlines\ArbitrationAwardNotIssuedOrNotReceived::class);
        $this->call(\Seeds\Deadlines\MotionToTransferCaseToAnotherCourt::class);
        $this->call(\Seeds\Deadlines\ExpertWitnessList::class);
        $this->call(\Seeds\Deadlines\HearingForDiscoveryOfPeaceOfficerPersonnelRecordsInCivilActionPursuantToSection1043OfTheEvidenceCode::class);
        // $this->call(\Seeds\Deadlines\Complaint::class);

        $this->call(\Seeds\RolesSeeder::class);
        $this->call(\Seeds\RequestsStatusSeeder::class);

        $this->call(\Seeds\ExperienceLevelsSeeder::class);
        $this->call(\Seeds\CountiesSeeder::class);
        $this->call(\Seeds\CountiesEFilingSeeder::class);
    }
}
