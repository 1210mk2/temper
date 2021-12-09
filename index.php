<?php
require_once 'vendor/autoload.php';

$ds = DIRECTORY_SEPARATOR;
$input_path     = "input"   . $ds;

$extension_to_strategy = [
    "csv"   => \App\InputData\Strategies\Csv::class,
    "tsv"   => \App\InputData\Strategies\Tsv::class,
//    "json"  => \App\InputData\Strategies\Json::class,
];

try {
    $_file_service = new \App\Services\FileService($input_path);

    $input_file_names = $_file_service->getAllFilenamesFromInputFolder();

    $strategies_collection = $_file_service->getInputFileProcessingStrategiesCollection($input_file_names, $extension_to_strategy);

    $_processing_service = new \App\Services\ProcessingService();

    $_processing_service->process($strategies_collection);



} catch (Throwable $exception) {
    echo "Errors\n";
    echo $exception->getMessage();
    die();
}

echo "OK";
