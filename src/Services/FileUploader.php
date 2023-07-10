<?php // src/Service/FileUploader.php
namespace App\Services;

use Exception;
use Symfony\Component\DependencyInjection\Parameter;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\String\Slugger\SluggerInterface;
use function imagecreatefromjpeg;

class FileUploader
{
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    public function add(UploadedFile $picture, ?string $folder = '', ?int $width = 250, ?int $height = 250)
    {
        $fichier = md5(uniqid(rand(), true)) . 'wbp';

        $picture_info = getimagesize($picture);

        if ($picture_info === false) {
            throw new Exception('Format d\'image incorrect');
        }
        switch ($picture_info['mime']) {
            case 'image/png':
                $picture_info = imagecreatefrompng($picture);
                break;
            case 'image/jpeg':
                $picture_info = imagecreatefromjpeg($picture);
                break;

            default:
                throw new Exception('Format d\'image incorrect');
                break;
        }


        $imageWidth = $picture_info[0];
        $imageHeight = $picture_info[1];

        // onn vérifie l'orientation 

        switch ($imageWidth <=> $imageHeight) {
            case -1: //portrait
                $squareSize = $imageWidth;
                $src_x = 0;
                $src_y = ($imageHeight - $squareSize) / 2;
                break;
            case 0: //carré
                $squareSize = $imageWidth;
                $src_x = 0;
                $src_y = 0;
                break;
            case 1: //paysage
                $squareSize = $imageHeight;
                $src_y = 0;
                $src_x = 0;
                break;
        }

        // création d'une image vierge

        $resized_picture = imagecreatetruecolor($width, $height);

        imagecopyresampled($resized_picture, $picture_source, 0, 0, $src_x, $src_y, $width, $height, $squareSize, $squareSize);
        $path = $this->params->get('images_directory') . $folder;

        // dossier de destination

        if (!file_exists($path . '/mini')) {
            mkdir($path . '/mini/', 0755, true);
        }

        //stocke image recadrée

        imagewebp($resized_picture, $path . '/mini./' . $width . 'x' . $height . '-' . $fichier);
        $picture->move($path . '/' . $fichier);

        return $fichier;
    }

    public function delete(string $fichier, ?string $folder = '', ?int $width = 250, ?int $height = 250)
    {
        if ($fichier !== 'default.webp') {
            $success = false;
            $path = $this->params->get('images_directory') . $folder;

            $mini = $path . '/mini./' . $width . 'x' . $height . '-' . $fichier;

            if (file_exists($mini)) {
                unlink($mini);
                $success = true;
            }
            return $success;
        }
        return false;
    }
}