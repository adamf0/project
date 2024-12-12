<?php
/* 
obobsolete
*/
namespace App\Rules;

use Architecture\External\Persistance\ORM\PenelitianNasional;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckSkemaNasional implements ValidationRule
{
    public function __construct(public $id_penelitian_internal=null,public $kategori_skema=[]){} 
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $penelitianNasional = PenelitianNasional::select('id','id_skema')
                                                ->with(["KategoriSkema"=>fn($query)=>$query->select('id','nama')])
                                                ->find($this->id_penelitian_internal);
        // dd(in_array($penelitianNasional->KategoriSkema?->nama, $this->kategori_skema));

        if (in_array($penelitianNasional->KategoriSkema?->nama, $this->kategori_skema)) {
            $fail("The :attribute field is required");
        }
    }
}
