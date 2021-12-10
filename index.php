<?php
ini_set('display_errors','Off');

require_once 'vendor/autoload.php';

$ds = DIRECTORY_SEPARATOR;
$input_path     = "input"   . $ds;

$extension_to_strategy = [
    "csv"   => \App\InputData\Strategies\Csv::class,
    "tsv"   => \App\InputData\Strategies\Tsv::class,
    "json"  => \App\InputData\Strategies\Json::class,
];

$steps = [
    (object)[
        "name"  => "Create account",
        "perc"  => 0,
    ],
    (object)[
        "name"  => "Activate account",
        "perc"  => 20,
    ],
    (object)[
        "name"  => "Provide profile information",
        "perc"  => 40,
    ],
    (object)[
        "name"  => "What jobs are you interested in?",
        "perc"  => 50,
    ],
    (object)[
        "name"  => "Do you have relevant experience in these jobs?",
        "perc"  => 70,
    ],
    (object)[
        "name"  => "Are you a freelancer?",
        "perc"  => 90,
    ],
    (object)[
        "name"  => "Waiting for approval",
        "perc"  => 99,
    ],
    (object)[
        "name"  => "Approval",
        "perc"  => 100,
    ],
];
$ts_week_diff = 7 * 24 * 60 * 60;

try {
    $_file_service = new \App\Services\FileService($input_path);

    $input_file_names = $_file_service->getAllFilenamesFromInputFolder();

    $strategies_collection = $_file_service->getInputFileProcessingStrategiesCollection($input_file_names, $extension_to_strategy);

    $_user_repo      = new \App\Repo\UserRepo();
    $_user_data_repo = new \App\Repo\UserDataRepo($_user_repo);


    $_processing_service = new \App\Services\ProcessingService($_user_repo, $_user_data_repo);

    $_processing_service->process($strategies_collection);

    $data = $_processing_service->calculate($ts_week_diff, $steps);

    $result = [
        "success"   => 1,
        "data"      => $data,
        "steps"     => $steps,
    ];

} catch (Throwable $exception) {

    http_response_code(422);
    $result = [
        "success"   => 0,
        "error"      => $exception->getMessage(),
    ];
}

echo json_encode($result);
