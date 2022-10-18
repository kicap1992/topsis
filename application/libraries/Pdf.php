<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . '/third_party/tcpdf/tcpdf.php';

class Pdf extends TCPDF
{
  function __construct($orientation = 'P', $unit = 'mm', $format = 'A4', $unicode = true, $encoding = 'UTF-8', $diskcache = false, $pdfa = false)
  {
    parent::__construct($orientation, $unit, $format, $unicode, $encoding, $diskcache, $pdfa);
  }

  //Page header
  public function Header()
  {
    $this->SetFont('times', '', 2);
    $image_file = str_replace('https', 'http', base_url('assets/images/logo_mamuju_tengah.png'));

    $this->Image($image_file, 8, 4, 15, 17, 'PNG', '', '', true, 150, '', false, false, 0, false, false, false);
    $html = '
        <table  width="100%" >
          <tr>
            <td  style="font-size: 18px;font-weight: bold;"></td>
          </tr>
          <tr>
            <td align="center" style="font-size: 12px;font-weight: bold;">
              PEMERINTAH KABUPATEN MAMUJU TENGAH
            </td>
          </tr>
          <tr>
            <td align="center" style="font-size: 12px;font-weight: bold;">
              DINAS PARIWISATA KEPEMUDAAN DAN OLAHRAGA
            </td>
          </tr>
          <tr>
            <td align="center" style="font-size: 9px;font-style:italic">
              Jl, Abdul Majid Pattaro Pura Kab. Mamuju Tengah, Prov. Sulawesi Barat
            </td>
          </tr>
        </table>
        <hr>
        <hr>
    ';

    $this->writeHTML($html, true, false, true, false, '');

    
    // $this->Ln(10);
  }
}
