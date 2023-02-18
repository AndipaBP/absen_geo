<?php

namespace App\Http\Controllers\Pengguna\Absensi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Absent;


class PenggunaAbsensiController extends Controller
{
    //


    private $lokasi_kantor = array();

    public function __construct(){

        $this->lokasi_kantor[0] =  -0.9043863629466407;
        $this->lokasi_kantor[1] = 119.84834306539048;

    }
    public function index(){

        $hari_ini = date('Y-m-d');
        $officer_id = Auth::user()->officer->id;
        $cek_absen = Absent::where('officer_id', $officer_id)->where('tanggal', $hari_ini)->first();

        $lokasi_kantor = $this->lokasi_kantor;

        return view('pengguna.absensi.index', compact('cek_absen','lokasi_kantor'));
    }

    public function store_absen(Request $request){
        // dd($request->all());

        $request->validate([
            "image"=>"required",
            "lokasi"=>"required",
        ]);

        $officer_id = Auth::user()->officer->id;

        $tgl_absen = Date("Y-m-d");
        $waktu_absen = Date("H:i:s");
        $lokasi = $request->lokasi;
        $image = $request->image;
        $folder_path = 'public/uploads/absensi';
        $format_name = $officer_id."-".$tgl_absen;
        $image_parts = explode(";base64", $image);
        $image_base64 = base64_decode($image_parts[1]);
        $file_name = $format_name.".png";
        $file = $folder_path.$file_name;

        $lokasi_kantor = $this->lokasi_kantor;
        $lokasi_user = explode(",",$lokasi);
        
        $jarak = $this->distance($lokasi_kantor[0], $lokasi_kantor[1], $lokasi_user[0], $lokasi_user[1]);
        $radius = round($jarak['meters']);

        // dd($radius);

        if($radius > 10){
            $notif = "error|Maaf, Anda Berada Diluar Radius, Jarak Anda ". $radius ." Meter Dari Kantor";

            // dd($notif);

        }
        else{

            $cek_absen = Absent::where('officer_id', $officer_id)->where('tanggal', $tgl_absen)->first();

            if(isset($cek_absen)){
    
                if ($cek_absen->jam_pulang === null) {
                    
                    $db_absen = Absent::where('officer_id', $officer_id)->where('tanggal', $tgl_absen)->first();
                    $db_absen->jam_pulang = $waktu_absen;
                    $db_absen->foto_pulang = $file_name;
                    $db_absen->location_pulang = $lokasi;
                    $db_absen->save();
    
                    Storage::put($file, $image_base64);
    
                    $notif = "success|Terimakasih, Hati Hati Dijalan|in";
    
                }
                else{
    
                    $notif = "error|Maaf, Anda Telah Absen Untuk Hari Ini |in,out";
    
                }
    
            }
            else{
    
    
                $db_absen = new Absent;
                $db_absen->officer_id = $officer_id;
                $db_absen->tanggal = $tgl_absen;
                $db_absen->jam_masuk = $waktu_absen;
                $db_absen->foto_masuk = $file_name;
                $db_absen->location_masuk = $lokasi;
                $db_absen->save();
    
                Storage::put($file, $image_base64);
    
                $notif = "success|Terimakasih, Selamat Bekerja|in";
    
            }
            
    
        }

        echo $notif;

       


    }

    // Menghitung Jarak
    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }
}
