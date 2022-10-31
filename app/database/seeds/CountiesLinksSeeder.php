<?php

use Illuminate\Database\Seeder;
use \App\Models\County;

class CountiesLinksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $counties = [
            [
            'name' => 'Alameda',
            'links' => [
                [
                    'url' => "https://www.alameda.courts.ca.gov/online-services/civil-e-filing/civil-e-filing-service-providers",
                    'title' => "Court E-Filing"
                ],
                [
                    'url' => "https://eportal.alameda.courts.ca.gov/?q=calendar/public/locations",
                    'title' => "Participating Depts."
                ],
                [
                    'url' => "https://eportal.alameda.courts.ca.gov/?q=Home",
                    'title' => "Tentative Rulings"
                ],
                [
                    'url' => "https://www.alameda.courts.ca.gov/general-information/remote-appearances",
                    'title' => "Remote Appearance Info"
                ],
                [
                    'url' => "https://eportal.alameda.courts.ca.gov/?q=node/387",
                    'title' => "Case Search"
                ],
                [
                    'url' => "https://www.alameda.courts.ca.gov/general-information/local-rules-forms",
                    'title' => "Local Rules"
                ],
            ]   
            ],
            [
                'name' => 'Alpine',
                'links' => [
                    [
                        'url' => "https://www.alpinecountyca.gov/212/Superior-Court-of-Alpine-County",
                        'title' => "Court Info"
                    ],
                    [
                        'url' => "https://www.alpine.courts.ca.gov/forms-filings/local-rules-standing-orders",
                        'title' => "Local Rules"
                    ],
                ]
            ],
            [
                'name' => 'Amador',
                'links' => [
                    [
                        'url' => "https://www.amadorcourt.org/os-tentativeRulings.aspx",
                        'title' => "Tentative Rulings, Hearing Reservation Info"
                    ],
                    [
                        'url' => "https://www.amadorcourt.org/dv-SearchNow.aspx",
                        'title' => "Case Info"
                    ],
                    [
                        'url' => "https://www.amadorcourt.org/ff-faxFiling.aspx#:~:text=The%20fax%20filing%20service%20may,Local%20Rule%20of%20Court%2011.16.",
                        'title' => "Fax Filing"
                    ],
                    [
                        'url' => "https://courtcall.com/_assets/pdf/CourtCall_Participating_Courts.pdf",
                        'title' => "CourtCall List"
                    ],
                    [
                        'url' => "https://www.amadorcourt.org/gi-zoomRequestForm.aspx",
                        'title' => "Zoom Appearance Info"
                    ],
                    [
                        'url' => "https://www.amadorcourt.org/gi-localRules.aspx",
                        'title' => "Local Rules"
                    ],
                    [
                        'url' => "https://www.amadorcourt.org/os-tentativeRulings.aspx",
                        'title' => "Tentative Rulings"
                    ],
                ]
            ],
            [
                'name' => 'Butte',
                'links' => [
                    [
                        'url' => "https://www.buttecourt.ca.gov/CaseInformation/eFiling/",
                        'title' => "Court E-Filing Info"
                    ],
                    [
                        'url' => "https://courtcall.com/_assets/pdf/CourtCall_Participating_Courts.pdf",
                        'title' => "CourtCall List"
                    ],
                    [
                        'url' => "https://www.buttecourt.ca.gov/TentativeRulings/",
                        'title' => "Tentative Rulings"
                    ],
                    [
                        'url' => "https://www.buttecourt.ca.gov/CaseInformation/",
                        'title' => "Case Search"
                    ],
                    [
                        'url' => "https://www.buttecourt.ca.gov/LocalRules/CurrentRules/",
                        'title' => "Local Rules"
                    ],
                ]
            ],
            [
                'name' => 'Colusa',
                'links' => [
                    [
                        'url' => "https://www.colusa.courts.ca.gov/general-information/court-calendar",
                        'title' => "General Motion Dates"
                    ],
                    [
                        'url' => "https://courtcall.com/_assets/pdf/CourtCall_Participating_Courts.pdf",
                        'title' => "CourtCall List"
                    ],
                    [
                        'url' => "https://www.cc-courts.org/general/local-rules.aspx",
                        'title' => "Local Rules"
                    ],
                ]
            ],
            [
            'name' => 'Contra Costa',
            'links' => [
                [
                'url' => "https://www.cc-courts.org/civil/motions-hearings-tentative.aspx",
                'title' => "Tentative Rulings"
                ],
                [
                'url' => "https://www.cc-courts.org/civil/civil.aspx",
                'title' => "Remote Appearance Info"
                ],
                [
                'url' => "https://courtcall.com/_assets/pdf/CourtCall_Participating_Courts.pdf",
                'title' => "CourtCall List"
                ],
                [
                'url' => "https://www.cc-courts.org/civil/online-case.aspx",
                'title' => "Case Search"
                ],
                [
                'url' => "https://www.cc-courts.org/general/local-rules.aspx",
                'title' => "Local Rules"
                ],
            ]
            ],
            [
            'name' => 'Calaveras',
            'links' => [[
            'url' => "https://www.alpine.courts.ca.gov/forms-filings/local-rules-standing-orders",
            'title' => "Local Rules"
            ],
            ]
            ],
            [
            'name' => 'Del Norte',
            'links' => [[
            'url' => "https://courtcall.com/_assets/pdf/CourtCall_Participating_Courts.pdf",
            'title' => "CourtCall List"
            ],
            [
            'url' => "https://ijsweb.delnorte.courts.ca.gov/CaseInquiry/#/caseInquiry",
            'title' => "Case Search"
            ],
            [
            'url' => "https://www.dncourt.com/general-info",
            'title' => "Local Rules"
            ],
            ]
            ],
            [
            'name' => 'El Dorado',
            'links' => [[
            'url' => "https://www.eldorado.courts.ca.gov/online-services/tentative-rulings",
            'title' => "Tentative Rulings"
            ],
            [
            'url' => "https://www.eldorado.courts.ca.gov/online-services/remote-appearances",
            'title' => "Remote Appearance Info"
            ],
            [
            'url' => "https://www.eldorado.courts.ca.gov/online-services/fax-filing-online",
            'title' => "Fax Filing Online"
            ],
            [
            'url' => "https://www.eldorado.courts.ca.gov/sites/default/files/eldorado/default/documents/Local%20Rules_Jul_2021_FINAL.pdf",
            'title' => "Local Rules"
            ],
            ]
            ],
            [
            'name' => 'Fresno',
            'links' => [[
            'url' => "https://www.fresno.courts.ca.gov/online-services/efile",
            'title' => "Court E-Filing"
            ],
            [
            'url' => "https://www.fresno.courts.ca.gov/online-services/tentative-rulings",
            'title' => "Tentative Rulings"
            ],
            [
            'url' => "https://www.fresno.courts.ca.gov/online-services/case-information",
            'title' => "Case Search"
            ],
            [
            'url' => "https://www.fresno.courts.ca.gov/forms-filing/local-rules",
            'title' => "Local Rules"
            ],
            ]
            ],
            [
            'name' => 'Glenn',
            'links' => [[
            'url' => "https://www.glenn.courts.ca.gov/self-help/case-search",
            'title' => "Case Search"
            ],
            [
            'url' => "https://www.glenn.courts.ca.gov/self-help/court-calendars",
            'title' => "Court Calendars"
            ],
            [
            'url' => "https://www.glenn.courts.ca.gov/general-information/local-rules",
            'title' => "Local Rules"
            ],
            [
            'url' => "https://courtcall.com/_assets/pdf/CourtCall_Participating_Courts.pdf",
            'title' => "CourtCall List"
            ],
            ]
            ],
            [
            'name' => 'Humboldt',
            'links' => [[
            'url' => "https://www.humboldt.courts.ca.gov/general-information/judicial-assignmentscalendars",
            'title' => "Remote Appearance Info"
            ],
            [
            'url' => "https://www.humboldt.courts.ca.gov/forms-filings/local-rules",
            'title' => "Local Rules"
            ],
            [
            'url' => "https://courtcall.com/_assets/pdf/CourtCall_Participating_Courts.pdf",
            'title' => "CourtCall List"
            ],
            ]
            ],
            [
            'name' => 'Imperial',
            'links' => [[
            'url' => "https://courtcall.com/_assets/pdf/CourtCall_Participating_Courts.pdf",
            'title' => "CourtCall List"
            ],
            [
            'url' => "https://www.imperial.courts.ca.gov/online-services/remote-appearances#:~:text=Remote%20Appearance%20Options,video%20conference%20when%20using%20CourtCall.",
            'title' => "Remote Appearance Info"
            ],
            [
            'url' => "https://www.imperial.courts.ca.gov/online-services/file-online",
            'title' => "Court E-Filing"
            ],
            [
            'url' => "https://www.humboldt.courts.ca.gov/forms-filings/local-rules",
            'title' => "Local Rules"
            ],
            ]
            ],
            [
            'name' => 'Inyo',
            'links' => [[
            'url' => "https://courtcall.com/_assets/pdf/CourtCall_Participating_Courts.pdf",
            'title' => "CourtCall List"
            ],
            [
            'url' => "https://www.inyo.courts.ca.gov/online-services",
            'title' => "Local Rules"
            ],
            ]
            ],
            [
            'name' => 'Kern',
            'links' => [[
            'url' => "https://www.kern.courts.ca.gov/online_services/efile",
            'title' => "Court E-Filing"
            ],
            [
            'url' => "https://www.kern.courts.ca.gov/online_services/remote_court_hearings",
            'title' => "Remote Appearance Info"
            ],
            [
            'url' => "https://eportal.alameda.courts.ca.gov/?q=node/387",
            'title' => "Case Search"
            ],
            [
            'url' => "https://www.courts.ca.gov/3027.htm",
            'title' => "Local Rules"
            ],
            [
            'url' => "https://courtcall.com/_assets/pdf/CourtCall_Participating_Courts.pdf",
            'title' => "CourtCall List"
            ],
            ]
            ],
            [
            'name' => 'Kings',
            'links' => [[
            'url' => "https://www.kings.courts.ca.gov/online-services/online-case-filing",
            'title' => "Court E-Filing Info"
            ],
            [
            'url' => "https://cakingsportal.tylerhost.net/CAKINGSPROD/",
            'title' => "Case Search"
            ],
            [
            'url' => "https://www.kings.courts.ca.gov/general-information/local-rules-standing-orders",
            'title' => "Local Rules"
            ],
            [
            'url' => "https://courtcall.com/_assets/pdf/CourtCall_Participating_Courts.pdf",
            'title' => "CourtCall List"
            ],
            ]
            ],
            [
            'name' => 'Lake',
            'links' => [[
            'url' => "https://www.lake.courts.ca.gov/gi/index.htm",
            'title' => "Local Rules"
            ],
            [
            'url' => "https://courtcall.com/_assets/pdf/CourtCall_Participating_Courts.pdf",
            'title' => "CourtCall List"
            ],
            ]
            ],
            [
            'name' => 'Lassen',
            'links' => [[
            'url' => "https://www.lassencourt.ca.gov/general_info/localrules.shtml",
            'title' => "Local Rules"
            ],
            [
            'url' => "https://courtcall.com/_assets/pdf/CourtCall_Participating_Courts.pdf",
            'title' => "CourtCall List"
            ],
            ]
            ],
            [
            'name' => 'Los Angeles',
            'links' => [[
            'url' => "https://www.lacourt.org/courtrules/ui/index.aspx",
            'title' => "Court E-Filing Info"
            ],
            [
            'url' => "https://www.lacourt.org/tentativeRulingNet/ui/main.aspx?casetype=civil",
            'title' => "Tentative Rulings"
            ],
            [
            'url' => "https://my.lacourt.org/laccwelcome",
            'title' => "Remote Appearance Info"
            ],
            [
            'url' => "https://www.lacourt.org/casesummary/ui/",
            'title' => "Case Search"
            ],
            [
            'url' => "https://www.lassencourt.ca.gov/general_info/localrules.shtml",
            'title' => "Local Rules"
            ],
            ]
            ],
            [
            'name' => 'Madera',
            'links' => [[
            'url' => "https://www.madera.courts.ca.gov/general-information/local-rules",
            'title' => "Local Rules"
            ],
            [
            'url' => "https://www.madera.courts.ca.gov/general-information/covid-19-information/remote-video-appearances",
            'title' => "Remote Appearance Info"
            ],
            [
            'url' => "https://www.madera.courts.ca.gov/online-services/case-information",
            'title' => "Case Search"
            ],
            ]
            ],
            [
            'name' => 'Marin',
            'links' => [[
            'url' => "http://www.marincourt.org/civil_tentative.cgi",
            'title' => "Tentative Rulings"
            ],
            [
            'url' => "https://www.marincourt.org/telephone_court_appear.htm",
            'title' => "Remote Appearance Info"
            ],
            [
            'url' => "http://www.marincourt.org/publicindex/SearchForm.aspx",
            'title' => "Case Search"
            ],
            [
            'url' => "https://www.marincourt.org/uniform_local_rules.cgi",
            'title' => "Local Rules"
            ],
            ]
            ],
            [
            'name' => 'Mariposa',
            'links' => [[
            'url' => "https://www.mariposa.courts.ca.gov/general-information/local-rules",
            'title' => "Local Rules"
            ],
            [
            'url' => "https://courtcall.com/_assets/pdf/CourtCall_Participating_Courts.pdf",
            'title' => "CourtCall List"
            ],
            [
            'url' => "https://www.mariposa.courts.ca.gov/remote",
            'title' => "Remote Appearance Info"
            ],
            ]
            ],
            [
            'name' => 'Mendocino',
            'links' => [[
            'url' => "https://www.mendocino.courts.ca.gov/e-filing",
            'title' => "Court E-Filing"
            ],
            [
            'url' => "https://www.mendocino.courts.ca.gov/online-services/court-information-portal",
            'title' => "Hearing Reservations"
            ],
            [
            'url' => "https://www.mendocino.courts.ca.gov/tentative-rulings",
            'title' => "Tentative Rulings"
            ],
            [
            'url' => "https://www.mendocino.courts.ca.gov/remote-court-appearances#:~:text=Criminal%20defendants%20who%20want%20to,days%20prior%20to%20the%20hearing.",
            'title' => "Remote Appearance Info"
            ],
            [
            'url' => "https://www.mendocino.courts.ca.gov/online-services/court-information-portal",
            'title' => "Case Search"
            ],
            [
            'url' => "https://www.mendocino.courts.ca.gov/general-information/court-rules-orders",
            'title' => "Local Rules"
            ],
            ]
            ],
            [
            'name' => 'Merced',
            'links' => [[
            'url' => "https://www.merced.courts.ca.gov/online-services/e-filing",
            'title' => "Court E-Filing"
            ],
            [
            'url' => "https://www.merced.courts.ca.gov/online-services/tentative-rulings",
            'title' => "Tentative Rulings"
            ],
            [
            'url' => "https://www.merced.courts.ca.gov/online-services/remote-appearances",
            'title' => "Remote Appearance Info"
            ],
            [
            'url' => "https://www.merced.courts.ca.gov/online-services/online-records",
            'title' => "Case Search"
            ],
            [
            'url' => "https://www.merced.courts.ca.gov/forms-filing/local-rules",
            'title' => "Local Rules"
            ],
            ]
            ],
            [
            'name' => 'Modoc',
            'links' => [[
            'url' => "https://courtcall.com/_assets/pdf/CourtCall_Participating_Courts.pdf",
            'title' => "CourtCall List"
            ],
            [
            'url' => "https://www.modoc.courts.ca.gov/forms-filing/local-rules",
            'title' => "Local Rules"
            ],
            ]
            ],
            [
            'name' => 'Mono',
            'links' => [[
            'url' => "https://courtcall.com/_assets/pdf/CourtCall_Participating_Courts.pdf",
            'title' => "CourtCall List"
            ],
            [
            'url' => "https://www.mono.courts.ca.gov/general-information/local-rules",
            'title' => "Local Rules"
            ],
            ]
            ],
            [
            'name' => 'Monterey',
            'links' => [[
            'url' => "https://www.monterey.courts.ca.gov/efiling",
            'title' => "Court E-Filing"
            ],
            [
            'url' => "https://www.monterey.courts.ca.gov/remote",
            'title' => "Remote Appearance Info"
            ],
            [
            'url' => "https://portal.monterey.courts.ca.gov/",
            'title' => "Case Search"
            ],
            [
            'url' => "https://www.monterey.courts.ca.gov/rules-of-court",
            'title' => "Local Rules"
            ],
            ]
            ],
            [
            'name' => 'Napa',
            'links' => [[
            'url' => "https://www.napa.courts.ca.gov/online-services/efile",
            'title' => "Court E-Filing"
            ],
            [
            'url' => "https://www.napa.courts.ca.gov/online-services/tentative-rulings",
            'title' => "Tentative Rulings"
            ],
            [
            'url' => "https://www.napa.courts.ca.gov/general-information/remote-appearance/courtroom-remote-appearances",
            'title' => "Remote Appearance Info"
            ],
            [
            'url' => "https://www.napa.courts.ca.gov/online-services/case-lookuppay-traffic-tickets",
            'title' => "Case Search"
            ],
            [
            'url' => "https://www.napa.courts.ca.gov/general-information/local-rules",
            'title' => "Local Rules"
            ],
            ]
            ],
            [
            'name' => 'Nevada',
            'links' => [[
            'url' => "https://www.nevada.courts.ca.gov/online-services/remote-hearings-and-document-filing",
            'title' => "Court E-Mail Filing"
            ],
            [
            'url' => "https://www.nevada.courts.ca.gov/online-services/tentative-rulings",
            'title' => "Tentative Rulings"
            ],
            [
            'url' => "https://www.nevada.courts.ca.gov/online-services/remote-hearings-and-document-filing",
            'title' => "Remote Appearance Info"
            ],
            [
            'url' => "https://www.nevada.courts.ca.gov/online-services/case-information",
            'title' => "Case Search"
            ],
            [
            'url' => "https://www.nevada.courts.ca.gov/forms-filing/rules-court",
            'title' => "Local Rules"
            ],
            ]
            ],
            [
            'name' => 'Orange',
            'links' => [[
            'url' => "https://www.occourts.org/online-services/efiling/efiling-civil.html",
            'title' => "E-Filing Info"
            ],
            [
            'url' => "https://www.occourts.org/online-services/tentative-rulings/",
            'title' => "Tentative Rulings"
            ],
            [
            'url' => "https://www.occourts.org/media-relations/remotehearings.html",
            'title' => "Remote Appearance Info"
            ],
            [
            'url' => "https://courtindex.occourts.org/",
            'title' => "Case Search"
            ],
            [
            'url' => "https://www.occourts.org/directory/local-rules/",
            'title' => "Local Rules"
            ],
            ]
            ],
            [
            'name' => 'Placer',
            'links' => [[
            'url' => "http://www.placer.courts.ca.gov/online-efiling.shtml",
            'title' => "Court E-Filing"
            ],
            [
            'url' => "http://www.placer.courts.ca.gov/tentative_rulings/tentative-rulings.shtml",
            'title' => "Tentative Rulings"
            ],
            [
            'url' => "http://www.placer.courts.ca.gov/RAS.shtml",
            'title' => "Remote Appearance Info"
            ],
            [
            'url' => "http://www.placer.courts.ca.gov/online-portal.shtml",
            'title' => "Case Search"
            ],
            [
            'url' => "http://www.placer.courts.ca.gov/general-local-rules.shtml",
            'title' => "Local Rules"
            ],
            ]
            ],
            [
            'name' => 'Plumas',
            'links' => [[
            'url' => "http://www.plumascourt.ca.gov/Rulings.htm",
            'title' => "Tentative Rulings"
            ],
            [
            'url' => "http://www.plumascourt.ca.gov/Fax.htm",
            'title' => "Fax Filing"
            ],
            [
            'url' => "https://courtcall.com/_assets/pdf/CourtCall_Participating_Courts.pdf",
            'title' => "CourtCall List"
            ],
            [
            'url' => "http://www.plumascourt.ca.gov/Local%20Rules.htm",
            'title' => "Local Rules"
            ],
            ]
            ],
            [
            'name' => 'Riverside',
            'links' => [[
            'url' => "https://www.riverside.courts.ca.gov/FormsFiling/EFiling/civil-efiling.php",
            'title' => "Court E-Filing"
            ],
            [
            'url' => "https://www.riverside.courts.ca.gov/OnlineServices/CourtReservation/court-reservation-system.php",
            'title' => "Hearing Reservations"
            ],
            [
            'url' => "https://www.riverside.courts.ca.gov/OnlineServices/TentativeRulings/tentative-rulings.php",
            'title' => "Tentative Rulings"
            ],
            [
            'url' => "https://www.riverside.courts.ca.gov/PublicNotices/remote-appearances.php#:~:text=The%20Riverside%20Superior%20Court%20currently,other%20electronic%20or%20communications%20device.",
            'title' => "Remote Appearance Info"
            ],
            [
            'url' => "https://www.riverside.courts.ca.gov/OnlineServices/SearchCourtRecords/public-access.php",
            'title' => "Case Search"
            ],
            [
            'url' => "https://www.riverside.courts.ca.gov/GeneralInfo/LocalRules/local-rules.php",
            'title' => "Local Rules"
            ],
            ]
            ],
            [
            'name' => 'Sacramento',
            'links' => [[
            'url' => "https://services.saccourt.ca.gov/PublicCaseAccess/Civil/TentativeRulingSearchByDepartment",
            'title' => "Tentative Rulings"
            ],
            [
            'url' => "https://www.saccourt.ca.gov/civil/docs/pn-civil-remote-and-in-person-proceedings-effective-monday-january-3-2022.pdf",
            'title' => "Remote Appearance Info"
            ],
            [
            'url' => "https://services.saccourt.ca.gov/PublicCaseAccess/",
            'title' => "Case Search"
            ],
            [
            'url' => "https://www.saccourt.ca.gov/local-rules/local-rules.aspx",
            'title' => "Local Rules"
            ],
            [
            'url' => "https://courtcall.com/_assets/pdf/CourtCall_Participating_Courts.pdf",
            'title' => "CourtCall List"
            ],
            ]
            ],
            [
            'name' => 'San Benito',
            'links' => [[
            'url' => "https://www.sanbenito.courts.ca.gov/",
            'title' => "Tentative Rulings"
            ],
            [
            'url' => "https://www.sanbenito.courts.ca.gov/general-information/local-rules",
            'title' => "Local Rules"
            ],
            [
            'url' => "https://courtcall.com/_assets/pdf/CourtCall_Participating_Courts.pdf",
            'title' => "CourtCall List"
            ],
            ]
            ],
            [
            'name' => 'San Bernardino',
            'links' => [[
            'url' => "https://support.onelegal.com/california-court-info/san-bernardino-county-superior-court",
            'title' => "TurboCourt Filing Info"
            ],
            [
            'url' => "https://www.sb-court.org/divisions/civil/civil-tentative-rulings",
            'title' => "Tentative Rulings"
            ],
            [
            'url' => "https://www.sb-court.org/general-information/courtroom-audio-streaming",
            'title' => "Remote Appearance Info"
            ],
            [
            'url' => "https://www.sb-court.org/sites/default/files/Forms%20and%20Rules/rulesofcourt.pdf",
            'title' => "Local Rules"
            ],
            [
            'url' => "https://courtcall.com/_assets/pdf/CourtCall_Participating_Courts.pdf",
            'title' => "CourtCall List"
            ],
            ]
            ],
            [
            'name' => 'San Diego',
            'links' => [[
            'url' => "https://support.onelegal.com/california-court-info/san-bernardino-county-superior-court",
            'title' => "E-Filing, Hearing Reservation, Tentative Rulings, Case Search"
            ],
            [
            'url' => "https://www.sdcourt.ca.gov/sdcourt/civil2/civilicvirtualhearings#virtualhearinglinktable",
            'title' => "Remote Appearance Info"
            ],
            [
            'url' => "https://www.sdcourt.ca.gov/sites/default/files/SDCOURT/GENERALINFORMATION/LOCALRULESOFCOURT/2022_san_diego_county_superior_court_rules.pdf",
            'title' => "Local Rules"
            ],
            ]
            ],
            [
            'name' => 'San Francisco',
            'links' => [[
            'url' => "https://www.sfsuperiorcourt.org/online-services/efiling#:~:text=Electronic%20Filing%20(E%2DFiling)%20Information&text=On%20May%2015%2C%202018%2C%20the,required%20to%20be%20filed%20electronically.",
            'title' => "Court E-Filing"
            ],
            [
            'url' => "https://www.sfsuperiorcourt.org/online-services/tentative-rulings",
            'title' => "Tentative Rulings"
            ],
            [
            'url' => "https://www.sfsuperiorcourt.org/virtual-courtrooms",
            'title' => "Remote Appearance Info"
            ],
            [
            'url' => "https://webapps.sftc.org/captcha/captcha.dll?referrer=https://webapps.sftc.org/ci/CaseInfo.dll?",
            'title' => "Case Search"
            ],
            [
            'url' => "https://www.sfsuperiorcourt.org/node/96",
            'title' => "Local Rules"
            ],
            [
            'url' => "https://courtcall.com/_assets/pdf/CourtCall_Participating_Courts.pdf",
            'title' => "CourtCall List"
            ],
            ]
            ],
            [
            'name' => 'San Luis Obispo',
            'links' => [[
            'url' => "https://www.slo.courts.ca.gov/online-services/online-case-filing",
            'title' => "Court E-Filing"
            ],
            [
            'url' => "https://www.slo.courts.ca.gov/online-services/tentative-rulings",
            'title' => "Tentative Rulings"
            ],
            [
            'url' => "https://drive.google.com/file/d/1dasAAcABoLnmC4YOOuREG_Y2eThjGVHz/view",
            'title' => "Remote Appearance Info"
            ],
            [
            'url' => "https://www.slo.courts.ca.gov/online-services/attorney-portal",
            'title' => "Case Search"
            ],
            [
            'url' => "https://www.slo.courts.ca.gov/forms-filing/local-rules",
            'title' => "Local Rules"
            ],
            [
            'url' => "https://courtcall.com/_assets/pdf/CourtCall_Participating_Courts.pdf",
            'title' => "CourtCall List"
            ],
            ]
            ],
            [
            'name' => 'San Mateo',
            'links' => [[
            'url' => "https://www.sanmateocourt.org/online_services/",
            'title' => "Online Services"
            ],
            [
            'url' => "https://www.sanmateocourt.org/general_info/local_rules/",
            'title' => "Local Rules"
            ],
            ]
            ],
            [
            'name' => 'Santa Barbara',
            'links' => [[
            'url' => "https://www.sbcourts.org/os/",
            'title' => "Online Services"
            ],
            [
            'url' => "http://www.odysseyefileca.com/service-providers.htm",
            'title' => "Court E-Filing"
            ],
            [
            'url' => "https://www.sbcourts.org/ff/local-rulesTOC.shtm",
            'title' => "Local Rules"
            ],
            ]
            ],
            [
            'name' => 'Santa Clara',
            'links' => [[
            'url' => "https://www.scscourt.org/forms_and_filing/efiling.shtml",
            'title' => "Court E-Filing Info"
            ],
            [
            'url' => "https://www.scscourt.org/online_services/case_info.shtml",
            'title' => "Case Search"
            ],
            [
            'url' => "https://www.scscourt.org/online_services/civil_law_and_motion_dates.shtml",
            'title' => "Hearing Reservation via Phone"
            ],
            [
            'url' => "https://www.scscourt.org/online_services/tentatives/tentative_rulings.shtml",
            'title' => "Tentative Rulings"
            ],
            ]
            ],
            [
            'name' => 'Santa Cruz',
            'links' => [[
            'url' => "https://www.santacruz.courts.ca.gov/forms-filing/electronic-filing",
            'title' => "Court E-Filing"
            ],
            [
            'url' => "https://www.santacruz.courts.ca.gov/online-services/civil-tentative-rulings",
            'title' => "Tentative Rulings"
            ],
            [
            'url' => "https://www.santacruz.courts.ca.gov/online-services/participating-remotely-zoom",
            'title' => "Remote Appearance Info"
            ],
            [
            'url' => "https://www.santacruz.courts.ca.gov/online-services/case-lookup",
            'title' => "Case Search"
            ],
            [
            'url' => "https://www.santacruz.courts.ca.gov/forms-filing/local-rules",
            'title' => "Local Rules"
            ],
            ]
            ],
            [
            'name' => 'Shasta',
            'links' => [[
            'url' => "https://www.shasta.courts.ca.gov/Online-Services/Tentative-Rulings.shtml",
            'title' => "Tentative Rulings"
            ],
            [
            'url' => "www.shasta.courts.ca.gov/Online-Services/Remote-Access.shtml",
            'title' => "Remote Appearance Info"
            ],
            [
            'url' => "https://www.shasta.courts.ca.gov/Online-Services/Court-Case-Records.shtml",
            'title' => "Case Search"
            ],
            [
            'url' => "www.shasta.courts.ca.gov/PDFs/roc.pdf",
            'title' => "Local Rules"
            ],
            [
            'url' => "https://courtcall.com/_assets/pdf/CourtCall_Participating_Courts.pdf",
            'title' => "CourtCall List"
            ],
            ]
            ],
            [
            'name' => 'Sierra',
            'links' => [[
            'url' => "https://www.sierra.courts.ca.gov/",
            'title' => "Court Home Page"
            ],
            ]
            ],
            [
            'name' => 'Solano',
            'links' => [[
            'url' => "https://solano.courts.ca.gov/",
            'title' => "Court Home Page"
            ],
            ]
            ],
            [
            'name' => 'Sonoma',
            'links' => [[
            'url' => "http://sonoma.courts.ca.gov/online-services/e-Filing",
            'title' => "E-Filing"
            ],
            [
            'url' => "http://sonoma.courts.ca.gov/online-services/tentative-rulings",
            'title' => "Tentative Rulings"
            ],
            [
            'url' => "http://sonoma.courts.ca.gov/divisions/civilcovid19",
            'title' => "Court Hearing - Zoom"
            ],
            [
            'url' => "https://www.shasta.courts.ca.gov/Online-Services/Court-Case-Records.shtml",
            'title' => "Case Search"
            ],
            [
            'url' => "http://sonoma.courts.ca.gov/info/local-rules",
            'title' => "Local Rules"
            ],
            ]
            ],
            [
            'name' => 'Stanislaus',
            'links' => [[
            'url' => "https://www.stanct.org/e-filing",
            'title' => "E-Filing"
            ],
            [
            'url' => "https://www.stanct.org/tentative-ruling-announcements",
            'title' => "Tentative Rulings"
            ],
            [
            'url' => "https://www.stanct.org/remote-telephonic-hearings",
            'title' => "Remote Court Hearings"
            ],
            [
            'url' => "https://www.stanct.org/case-index-lookup",
            'title' => "Case Search"
            ],
            [
            'url' => "https://www.stanct.org/sites/default/files/u131/FINAL%20Local%20Rules_Stan%20Sup%20Court_Eff%2001.01.2021_%20UPDATE%2012.02.2020_0.PDF",
            'title' => "Local Rules"
            ],
            ]
            ],
            [
            'name' => 'Sutter',
            'links' => [[
            'url' => "https://www.sutter.courts.ca.gov/online-services/e-file",
            'title' => "E-Filing"
            ],
            [
            'url' => "https://www.stanct.org/tentative-ruling-announcements",
            'title' => "Tentative Rulings"
            ],
            [
            'url' => "https://www.stanct.org/remote-telephonic-hearings",
            'title' => "Remote Court Hearings"
            ],
            [
            'url' => "https://www.stanct.org/case-index-lookup",
            'title' => "Case Search"
            ],
            [
            'url' => "https://www.sutter.courts.ca.gov/general-information/local-rules-court",
            'title' => "Local Rules"
            ],
            ]
            ],
            [
            'name' => 'Tehama',
            'links' => [[
            'url' => "https://support.onelegal.com/california-court-info/tehama-county-superior-court",
            'title' => "E-Filing"
            ],
            [
            'url' => "https://www.tehama.courts.ca.gov/divisions/civil-family-law/civil-family-and-probate-remote-appearance-information",
            'title' => "Remote Court Hearings"
            ],
            [
            'url' => "https://www.tehama.courts.ca.gov/general-information/local-rules",
            'title' => "Local Rules"
            ],
            ]
            ],
            [
            'name' => 'Trinity',
            'links' => [[
            'url' => "https://www.trinity.courts.ca.gov/online-services/court-calendars",
            'title' => "Remote Court Hearings"
            ],
            [
            'url' => "https://www.trinity.courts.ca.gov/general-information/local-rules",
            'title' => "Local Rules"
            ],
            ]
            ],
            [
            'name' => 'Tulare',
            'links' => [[
            'url' => "https://www.tulare.courts.ca.gov/online-services/efiling",
            'title' => "E-Filing"
            ],
            [
            'url' => "https://www.tulare.courts.ca.gov/general-information/tentative-rulings",
            'title' => "Tentative Rulings"
            ],
            [
            'url' => "https://www.tulare.courts.ca.gov/courtroom-remote-appearance",
            'title' => "Remote Court Hearings"
            ],
            [
            'url' => "https://www.stanct.org/case-index-lookup",
            'title' => "Case Search"
            ],
            [
            'url' => "https://www.stanct.org/sites/default/files/u131/FINAL%20Local%20Rules_Stan%20Sup%20Court_Eff%2001.01.2021_%20UPDATE%2012.02.2020_0.PDF",
            'title' => "Local Rules"
            ],
            ]
            ],
            [
            'name' => 'Tuolumne',
            'links' => [[
            'url' => "https://www.tuolumne.courts.ca.gov/",
            'title' => "Court Home Page"
            ],
            ]
            ],
            [
            'name' => 'Ventura',
            'links' => [[
            'url' => "https://www.ventura.courts.ca.gov/",
            'title' => "Court Home Page"
            ],
            ]
            ],
            [
            'name' => 'Yolo',
            'links' => [[
            'url' => "https://www.yolo.courts.ca.gov/online-services/efile-court-documents",
            'title' => "E-Filing"
            ],
            [
            'url' => "https://www.yolo.courts.ca.gov/online-services/tentative-rulings-calendar",
            'title' => "Tentative Rulings"
            ],
            [
            'url' => "https://www.yolo.courts.ca.gov/online-services/zoom-remote-appearances",
            'title' => "Remote Court Hearings"
            ],
            [
            'url' => "https://www.yolo.courts.ca.gov/general-information/local-rules-news-notices-orders-and-policies",
            'title' => "Local Rules"
            ],
            ]
            ],
            [
            'name' => 'Yuba',
            'links' => [[
            'url' => "https://www.yuba.courts.ca.gov/online-services/efiling",
            'title' => "E-Filing"
            ],
            [
            'url' => "https://www.yuba.courts.ca.gov/online-services/online-case-access",
            'title' => "Case Search"
            ],
            [
            'url' => "https://www.yuba.courts.ca.gov/general-information/local-rules-court",
            'title' => "Local Rules"
            ],
            ]
            ],
        ];
        foreach ($counties as $county) {
            County::where('name', $county['name'])->update(['links' => $county['links']]);
        }
    }
}
