<?php


namespace App\Services;


use App\InputData\Strategies\InputFileInterface;

class FileService
{
    private string $input_folder_path;

    public function __construct(string $input_folder_path)
    {
        $this->input_folder_path  = $input_folder_path;
    }


    public function exist($filename)
    {
        return is_file($filename);
    }

    public function info($filename)
    {
        return pathinfo($filename);
    }

    public function all(string $path): array
    {
        $items = scandir($path);
        $items = array_slice($items, 2);
        return $items;
    }


    public function getAllFilenamesFromInputFolder(): array
    {
        return $this->all($this->input_folder_path);
    }

    /**
     * @return array<string, InputFileInterface>
     */
    public function getInputFileProcessingStrategiesCollection(array $file_names, array $extension_to_strategy): array
    {
        $strategies = [];
        foreach ($file_names as $file_name) {

            $full_file_name = $this->input_folder_path . $file_name;

            $info = $this->info($full_file_name);
            $ext  = $info['extension'];

            $strategy_class_name = $extension_to_strategy[$ext] ?? null;

            if (!$strategy_class_name) {
                continue;
            }
            $strategies[] = new $strategy_class_name($full_file_name);
        }
        return $strategies;
    }

}