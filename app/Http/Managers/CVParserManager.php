<?php namespace App\Http\Managers;


class CVParserManager
{
    private static $public_path = __DIR__ . '/../../../public/';
    private static $cvs_dir = __DIR__ . '/../../../public/cvs';
    private static $file_name = 'parsed cv.zip';
    private static $cvs_arr = [];

    public function process($file)
    {
        self::unzipFile($file);

        self::listAllIndustriesInUnzippedFolder();

        self::parse();

    }

    public function parse()
    {
        foreach (self::$cvs_arr as $key => $value) {

            $percentage = ceil(++$key / count(self::$cvs_arr) * 100);

            $cv_name = substr($value['cv_path'], strrpos($value['cv_path'], '/') + 1);

            self::info('[' . ($key) . '/' . count(self::$cvs_arr) . ' -- ' . $percentage . '%] ' . $value['industry_name'] . '/' . $cv_name, 'rgb(6, 172, 255)', $percentage, true);

            \CV::parse($value['cv_path']);

//            app(JobzellaManager::class)->processCvInfo(\CV::parse($value['cv_path']));

        }
        self::info("Finished :D", '#2bbc8a');
    }


    public function unzipFile($file)
    {
        self::info("Unzipping folder ....");

        $zipper = new \Chumper\Zipper\Zipper;

        if (is_dir(self::$cvs_dir))
            system("rm -rf " . escapeshellarg(self::$cvs_dir));

        if (is_file(self::$public_path . self::$file_name))
            unlink(self::$public_path . self::$file_name);

        if ($file === null || $file->getMimeType() != 'application/zip') {
            self::info("Error!! you must select a zip file to upload !.. \n Process over .. Please try again with a proper zip file.", 'red');
            die();
        }

        $file->move(self::$public_path, self::$file_name);
        $zipper->make(self::$public_path . self::$file_name)->extractTo(self::$cvs_dir);
    }

    public function listAllIndustriesInUnzippedFolder()
    {
        self::info("Listing all industries inside unzipped folder ....");

        $industries = array_diff(scandir(self::$cvs_dir), ['..', '.']);

        foreach ($industries as $industry) {
            $path = self::$cvs_dir . '/' . $industry;

            if (!is_dir($path)) continue;

            $cvs = array_diff(scandir($path), ['..', '.']);

            foreach ($cvs as $cv) {
                $cv = $path . '/' . $cv;
                array_push(self::$cvs_arr, ['cv_path' => $cv, 'industry_name' => $industry]);
            }

        }
    }

    public function info($text, $color = '#c9cacc', $progress = 0, $text_shadow = false)
    {
        ob_flush();
        echo json_encode(['message' => $text, 'progress' => $progress, 'color' => $color, 'text_shadow' => $text_shadow]) . "##";
        flush();
    }

    public function __destruct()
    {
        ob_end_flush();
    }
}