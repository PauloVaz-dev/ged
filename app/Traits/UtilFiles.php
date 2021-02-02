<?php
/**
 * Created by PhpStorm.
 * User: paulo
 * Date: 12/20/19
 * Time: 2:41 PM
 */

namespace Serbinario\Traits;


use Illuminate\Contracts\Filesystem\FileNotFoundException;

trait UtilFiles
{



    public function ImageStore($request, String $field, $nameFile = null)
    {

        // Define o valor default para a variável que contém o nome da imagem

        // Verifica se informou o arquivo e se é válido
        if ($request->hasFile($field)){
            $file = $request->file($field);

            $slug = \Auth::user()->franquia->slug;
            $month = date('m');
            $day = date('d');
            $path = "storage/" . $slug . "/" . $month . $day;

            try {
                $extension = $file->getClientOriginalExtension();

                if($nameFile){
                    $nameFile = "{$nameFile}";
                }else{
                    $name = uniqid(date('HisYmd'));
                    $nameFile = "{$name}.{$extension}";
                }

                $fileStatus = $file->move($path,$nameFile);
                if ( $fileStatus ){
                    return $path . "/" .$nameFile;
                }
            } catch (FileNotFoundException $e) {
                dd("Errro", $e);
            }
        }else{
            return $nameFile;
        }
    }

    public function ImageStoreV2($file, String $field, $nameFile = null)
    {
            try {
                // File Details
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $tempPath = $file->getRealPath();
                $fileSize = $file->getSize();
                $mimeType = $file->getMimeType();

                $slug = \Auth::user()->franquia->slug;
                $month = date('m');
                $day = date('d');
                $path = "storage/" . $slug . "/" . $month . $day;

                if($nameFile){
                    $nameFile = "{$nameFile}";
                }else{
                    $name = uniqid(date('HisYmd'));
                    $nameFile = "{$name}.{$extension}";
                }

                $fileStatus = $file->move($path,$nameFile);
                if ( $fileStatus ){
                    return $path . "/" .$nameFile;
                }
            } catch (FileNotFoundException $e) {
                dd("Errro", $e);
            }

    }

}