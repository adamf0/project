<?php

namespace Architecture\Shared\Facades;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use ReflectionClass;
use ReflectionProperty;
// use Architecture\Domain\Enum\TypeStatusAdministrasi;

trait Utility
{
    public static function showNotif()
    {
        return AlertNotif::show();
    }
    public static function stateMenu($segment=[],Request $request)
    {
        if(count($segment)==0) throw new Exception('invalid argument');

        return in_array($request->segments()[0],$segment);
    }
    public static function isAlterMode()
    {
        $found = false;
        foreach(Session::all() as $key => $_){
            if (preg_match("/^alter_\w+$/", $key)) {
                $found = true;
                break;
            }
        }
        return $found;
    }
    public static function getName()
    {
        return (Session::get('alter_name')??Session::get('name')) ?? 'N/A';
    }
    public static function getLevel($toLower=false)
    {
        return match (Session::get('alter_level')??Session::get('level')) {
            "admin"      => $toLower? "admin":"Admin",
            "prodi"     => $toLower? "prodi":"Prodi",
            "guest"      => $toLower? "guest":"Guest",
            default     => $toLower? "n/a":"N/A"
        };
    }
    public static function getNameFaculty()
    {
        $namaFakultas = self::hasDosen()? (Session::get('alter_namaFakultas')??Session::get('namaFakultas')):"";
        return empty($namaFakultas)? "":" $namaFakultas";
    }
    public static function getLevels()
    {
        return Session::get('alter_level')??Session::get('level');
    }
    public static function hasMultiLevel()
    {
        if(Session::has('alter_level')){
            return ((Session::get('alter_level')??Session::get('alter_level'))??collect([]))->count()>1;
        }
        if(is_array(Session::get('level'))){
            return ((Session::get('level')??Session::get('level'))??collect([]))->count()>1;
        }

        return false;
    }
    public static function hasAdmin()
    {
        return (Session::get('alter_level')??Session::get('level')) == "admin";
    }
    public static function hasProdi()
    {
        return (Session::get('alter_level')??Session::get('level')) == "prodi";
    }
    public static function hasGuest()
    {
        return (Session::get('alter_level')??Session::get('level')) == "guest";
    }
    
    public static function loadAsset($path)
    {
        return env('DEPLOY', 'dev') == 'dev' ? asset($path) : secure_asset($path);
    }
    public static function toStatusPengajuan($val)
    {
        return match ($val) {
            "menunggu"  => null,
            "verif"     => 1,
            "tolak"     => 0,
            default     => -1
        };
    }
    public static function checkValidList(?Collection $list = null, object $targetTypeOf, $label){
        if(is_null($list)) throw new Exception("value list can't be null");
        if(is_null($targetTypeOf)) throw new Exception("value targetTypeOf can't be null");
        if(is_null($label)) throw new Exception("value label can't be null");

        foreach($list as $item){
            if(!is_a($item, get_class($targetTypeOf))) throw new Exception("invalid typeOf in $label");
        }
        return true;
    }

    public static function checkValidStep($step)
    {
        $stepNumber = (int) str_replace('step', '', $step);
        if (
            !in_array($stepNumber, [1, 2, 3, 4]) || 
            (is_integer($step) && !in_array($step, [1, 2, 3, 4]))
        ) throw new Exception("invalid to access step");
        
        return true;
    }
    public static function createStepper($maxStep,$startStep=1)
    {
        $listStepper = collect([]);
        for ($i = 1; $i <= 4; $i++) {
            $listStepper->push((object)[
                'isActive'      => $i == $startStep,
                'isDisable'     => $i > $startStep,
                'numberStep'    => $i,
                'isEndStep'     => $i == $maxStep,
            ]);
        }
        return $listStepper;
    }
    public static function getAttributClass($class,$except=[],$mapping=[]){
        $reflect = new ReflectionClass($class);
        $properties = $reflect->getProperties(ReflectionProperty::IS_PUBLIC);
        $index=0;
        return collect($properties)->mapWithKeys(function ($property) use (&$index,&$class,&$except,&$mapping) {
            $propertyName = isset($mapping[$property->getName()])? $mapping[$property->getName()] : $property->getName();
            $propertyValue = $property->getValue($class);

            // if(!($propertyValue instanceof TypeStatusAdministrasi)) return [];
            if(in_array($propertyName,$except)) return [];

            $output = [$index=>(object)["key"=>$propertyName,"value"=>$propertyValue]];
            $index++;
            return $output;
        });
    } 

    static function ruleSintaToString($rules,$x = 0){
        if(array_key_exists("value",$rules)){
            $checkMin = array_key_exists('min',$rules['value']);
            $checkMax = array_key_exists('max',$rules['value']);

            if($checkMin && $checkMax){
                return sprintf("%s %s %s %s %s",
                    '<span type="button" class="badge bg-warning text-black" data-bs-toggle="tooltip" data-bs-placement="top" title="Minimum Skor Sinta">
                    '.$rules['value']['min']['value'].'
                    </span>',
                    $rules['value']['min']['operator'],
                    '<span type="button" class="badge bg-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Skor Sinta Saya">
                    '.$x.'
                    </span>',
                    $rules['value']['max']['operator'],
                    '<span type="button" class="badge bg-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Maksimum Skor Sinta">
                    '.$rules['value']['max']['value'].'
                    </span>',
                );
            } else if($checkMin && !$checkMax){
                return sprintf("%s %s %s",
                    '<span type="button" class="badge bg-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Skor Sinta Saya">
                    '.$x.
                    '</span>',
                    $rules['value']['min']['operator'],
                    '<span type="button" class="badge bg-warning text-black" data-bs-toggle="tooltip" data-bs-placement="top" title="Minimum Skor Sinta">
                    '.$rules['value']['min']['value'].'
                    </span>',
                );
            } else if(!$checkMin && $checkMax){
                return sprintf("0 >= %s %s %s",
                    $x,
                    '<span type="button" class="badge bg-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Maksimum Skor Sinta">
                    '.$rules['value']['max']['value'].'
                    </span>',
                    $rules['value']['max']['operator']
                );
            } else {
                return "ada yg salah dengan aturannya";
            }
        } else{
            return '<span type="button" class="badge bg-primary">
                        tidak ada aturan khusus
                    </span>';
        }
    }
    static function getSinta($author_id=0,$maxRetry=3){
        $url = env("URL_SINTA","http://localhost:81")."/$author_id";
        for ($attempt = 1; $attempt <= $maxRetry; $attempt++) {
            try {
                $response = Http::get($url);
                $response->header('Access-Control-Allow-Origin', '*');

                $response = $response->json();
                return (int) str_replace(".","",$response["data"]["score"]["overall"]);
            } catch (\Exception $e) {
                if ($attempt < $maxRetry) {
                    sleep(1); // Delay 1 detik sebelum retry
                }
            }
        }
        return 0;
    }
}
