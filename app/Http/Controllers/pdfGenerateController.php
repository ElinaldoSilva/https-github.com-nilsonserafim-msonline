<?php

namespace App\Http\Controllers;

use App\Models\paineis_novo;
use DateTime;

class pdfGenerateController extends Controller
{

    public function generate($protocolo)
    {

        $regPainel = paineis_novo::where('PainelId', $protocolo)->get();

        $date = new DateTime($regPainel[0]['DataSepultamento']);

        $regSepultamento=array(
            "falecido"=>$regPainel[0]['Falecido'], 
            "data"=>$date->format('d/m/Y'), 
            "hora"=>$regPainel[0]['HorarioSepultamento'], 
            "funeraria"=>$regPainel[0]['NomeFuneraria']
        );

        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();    // $config

        $fontDirs = $defaultConfig['fontDir'];
        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $html = view('relSepultamento', compact('regSepultamento'))->render();

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($html);
        $mpdf->Output();
        return $mpdf->Output();

        /* $config = array(
            'mode'                  => '' ,
            'format'                => 'A4' ,
            'default_font_size'     => '12' ,
            'default_font'          => 'sans-serif' ,
            'margin_left'           => 10 ,
            'margin_right'          => 10 ,
            'margin_top'            => 10 ,
            'margin_bottom'         => 10 ,
            'margin_header'         =>0 ,
            'margin_footer'         =>0 ,
            'orientação'            => 'P' ,
            'title'                 => 'Laravel mPDF' ,
            'author'                => '' ,
            'watermark'             => '' ,
            'show_watermark'        => false ,
            'watermark_font'        => ' sans-serif ' ,
            ' display_mode '        => ' fullpage ' ,
            ' watermark_text_alpha' => 0.1,
            ' custom_font_dir '     => '' ,
            'custom_font_data' 	    => [],
            'auto_language_detection' => false ,
            'temp_dir'                => rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR ),
            'pdfa'  			=> false ,
            'pdfaauto'  		=> false );
        */    
    }
}
