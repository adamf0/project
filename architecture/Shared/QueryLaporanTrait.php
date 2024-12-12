<?php

namespace Architecture\Shared;

use Architecture\Domain\Enum\TypeStatusPengajuan;
use Illuminate\Support\Facades\DB;

trait QueryLaporanTrait
{
    public function scopeLaporan($query, $table, $tahun, $prodi=null)
    {
        $query->select("$table.id", "$table.NIDN", "CFakultas.nama_fakultas", "CProdi.nama_prodi", "$table.type", "$table.NIDN", "$table.tahun_pengajuan", "$table.status")
        ->leftJoin("connect_m_dosen as CDosen", "$table.NIDN", "=", "CDosen.NIDN")
        ->leftJoin("connect_m_fakultas as CFakultas", "CDosen.kode_fak", "=", "CFakultas.kode_fakultas")
        ->leftJoin("connect_m_program_studi as CProdi", "CDosen.kode_prodi", "=", "CProdi.kode_prodi")
        ->withCount([
            'Rab as total' => function($query) {
                $query->select(DB::raw('SUM(CASE 
                    WHEN satuan IS NOT NULL AND harga_satuan IS NOT NULL THEN satuan * harga_satuan 
                    WHEN total IS NOT NULL THEN total
                    ELSE 0 END
                )'));
            }, 
        ])
        ->where(function($query) use ($tahun) {
            $query->where(function($query) use ($tahun) {
                $query->where('type', 'import');
                $query->where(DB::raw('YEAR(tahun_pengajuan)'), $tahun);
            });
            $query->orWhere(function($query) use ($tahun) {
                $query->where('status', TypeStatusPengajuan::TERIMA_PENDANAAN->val());
                $query->where(DB::raw('YEAR(tahun_pengajuan)'), $tahun);
            });
        });
        if(!is_null($prodi)){
            $query->where('CDosen.kode_prodi',$prodi);
        }

        return $query;
    }
    public function scopeLaporanPPM($query, $table, $tahun, $prodi=null)
    {
        $query->select("$table.id","$table.nidnKetua","CFakultas.nama_fakultas","CProdi.nama_prodi","$table.tahunUsulanKegiatan",DB::raw("$table.danaDisetujui as total"),"$table.kategoriSumberDana","$table.negaraSumberDana","$table.namaSkema")
        ->leftJoin("connect_m_dosen as CDosen", "$table.nidnKetua", "=", "CDosen.NIDN")
        ->leftJoin("connect_m_fakultas as CFakultas", "CDosen.kode_fak", "=", "CFakultas.kode_fakultas")
        ->leftJoin("connect_m_program_studi as CProdi", "CDosen.kode_prodi", "=", "CProdi.kode_prodi");

        if(!is_null($prodi)){
            $query->where('CDosen.kode_prodi',$prodi);
        }
        if(!is_null($tahun)){
            $query->where(DB::raw('YEAR(tahunUsulanKegiatan)'), $tahun);
        }

        return $query;
    }
}