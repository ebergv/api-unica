<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 17/04/17
 * Time: 15:28
 */

namespace Prominas\Service;


class WorkloadService
{
    public function getWorkload($chtotal)
    {
        switch ($chtotal):
            case ($chtotal >= 30 && $chtotal <= 45):
                $cargaHoraria = 30;
                break;
            case ($chtotal > 45 && $chtotal <= 90):
                $cargaHoraria = 60;
                break;
            case ($chtotal > 90 && $chtotal <= 150):
                $cargaHoraria = 120;
                break;
            case ($chtotal > 150 && $chtotal <= 210):
                $cargaHoraria = 180;
                break;
            case ($chtotal > 210 && $chtotal <= 270):
                $cargaHoraria = 240;
                break;
            case ($chtotal > 270 && $chtotal <= 330):
                $cargaHoraria = 300;
                break;
            case ($chtotal > 330 && $chtotal <= 427):
                $cargaHoraria = 360;
                break;
            case ($chtotal > 427 && $chtotal <= 490):
                $cargaHoraria = 480;
                break;
            case ($chtotal > 490 && $chtotal <= 502):
                $cargaHoraria = 495;
                break;
            case ($chtotal > 502 && $chtotal <= 525):
                $cargaHoraria = 510;
                break;
            case ($chtotal > 525 && $chtotal <= 570):
                $cargaHoraria = 540;
                break;
            case ($chtotal > 570 && $chtotal <= 630):
                $cargaHoraria = 600;
                break;
            case ($chtotal > 630 && $chtotal <= 697):
                $cargaHoraria = 660;
                break;
            case ($chtotal > 697 && $chtotal <= 730):
                $cargaHoraria = 720;
                break;
            case ($chtotal > 730 && $chtotal <= 867):
                $cargaHoraria = 735;
                break;
            case ($chtotal > 867 && $chtotal <= 1000):
                $cargaHoraria = 1000;
                break;
            default:
                $cargaHoraria = false;
        endswitch;

        return $cargaHoraria;
    }
}