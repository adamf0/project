<?php

namespace Architecture\Shared;

use Architecture\External\Persistance\ORM\AkurasiPenelitian as ORMAkurasiPenelitian;
use Architecture\External\Persistance\ORM\InovasiPemecahanMasalah as ORMInovasiPemecahanMasalah;
use Architecture\External\Persistance\ORM\JumlahKolaboratorPublikasiBereputasi as ORMJumlahKolaboratorPublikasiBereputasi;
use Architecture\External\Persistance\ORM\KebaruanReferensi as ORMKebaruanReferensi;
use Architecture\External\Persistance\ORM\KejelasanPembagianTugasTim as ORMKejelasanPembagianTugasTim;
use Architecture\External\Persistance\ORM\KesesuaianTkt as ORMKesesuaianTkt;
use Architecture\External\Persistance\ORM\KesesuaianWaktuRabLuaranFasilitas as ORMKesesuaianWaktuRabLuaranFasilitas;
use Architecture\External\Persistance\ORM\KetajamanPerumusanMasalah as ORMKetajamanPerumusanMasalah;
use Architecture\External\Persistance\ORM\KredibilitasMitraDukungan as ORMKredibilitasMitraDukungan;
use Architecture\External\Persistance\ORM\ModelFeasibilityStudy as ORMModelFeasibilityStudy;
use Architecture\External\Persistance\ORM\PotensiKetercapaianLuaranDijanjikan as ORMPotensiKetercapaianLuaranDijanjikan;
use Architecture\External\Persistance\ORM\PublikasiDisitasiProposal as ORMPublikasiDisitasiProposal;
use Architecture\External\Persistance\ORM\RelevansiKepakaranTemaProposal as ORMRelevansiKepakaranTemaProposal;
use Architecture\External\Persistance\ORM\RelevansiKualitasReferensi as ORMRelevansiKualitasReferensi;
use Architecture\External\Persistance\ORM\RelevansiProdukKepentinganNasional as ORMRelevansiProdukKepentinganNasional;
use Architecture\External\Persistance\ORM\RoadmapPenelitian as ORMRoadmapPenelitian;
use Architecture\External\Persistance\ORM\SotaKebaharuan as ORMSotaKebaharuan;

use Architecture\External\Persistance\ORM\RumusanPrioritasMitra as ORMRumusanPrioritasMitra;
use Architecture\External\Persistance\ORM\ArtikelMediaMassa as ORMArtikelMediaMassa;
use Architecture\External\Persistance\ORM\KesesuaianJadwal as ORMKesesuaianJadwal;
use Architecture\External\Persistance\ORM\KesesuaianPenugasan as ORMKesesuaianPenugasan;
use Architecture\External\Persistance\ORM\KesesuaianSolusiMasalahMitra as ORMKesesuaianSolusiMasalahMitra;
use Architecture\External\Persistance\ORM\KetajamanAnalisis as ORMKetajamanAnalisis;
use Architecture\External\Persistance\ORM\KewajaranTahapanTarget as ORMKewajaranTahapanTarget;
use Architecture\External\Persistance\ORM\KualitasIpteks as ORMKualitasIpteks;
use Architecture\External\Persistance\ORM\KualitasKuantitasPublikasiJurnalIlmiah as ORMKualitasKuantitasPublikasiJurnalIlmiah;
use Architecture\External\Persistance\ORM\KualitasKuantitasPublikasiProsiding as ORMKualitasKuantitasPublikasiProsiding;
use Architecture\External\Persistance\ORM\KuantitasStatusKI as ORMKuantitasStatusKI;
use Architecture\External\Persistance\ORM\LuaranArtikel as ORMLuaranArtikel;
use Architecture\External\Persistance\ORM\MetodeRencanaKegiatan as ORMMetodeRencanaKegiatan;
use Architecture\External\Persistance\ORM\PeningkatanKeberdayaanMitra as ORMPeningkatanKeberdayaanMitra;
use Architecture\External\Persistance\ORM\VideoKegiatan as ORMVideoKegiatan;

trait MappingSubstansi
{
    public $listMapSubstansiInternal=[
        "Rekam jejak yang relevan" => [
            [
                "name"=>"PublikasiDisitasiProposal",
                "desc"=>"Publikasi, kekayaan intelektual, buku ketua pengusul yang disitasi pada proposal",
                "ref"=>ORMPublikasiDisitasiProposal::class,
            ],
            [
                "name"=>"RelevansiKepakaranTemaProposal",
                "desc"=>"Relevansi kepakaran pengusul dengan tema proposal (kata kunci)",
                "ref"=>ORMRelevansiKepakaranTemaProposal::class,
            ],
            [
                "name"=>"JumlahKolaboratorPublikasiBereputasi",
                "desc"=>"Jumlah kolaborator publikasi internasional bereputasi",
                "ref"=>ORMJumlahKolaboratorPublikasiBereputasi::class,
            ],
        ],
        "Urgensi penelitian" => [
            [
                "name"=>"RelevansiProdukKepentinganNasional",
                "desc"=>"Relevansi produk yang akan dikembangkan terhadap kepentingan nasional",
                "ref"=>ORMRelevansiProdukKepentinganNasional::class,
            ],
            [
                "name"=>"KetajamanPerumusanMasalah",
                "desc"=>"Ketajaman perumusan masalah",
                "ref"=>ORMKetajamanPerumusanMasalah::class,
            ],
            [
                "name"=>"InovasiPemecahanMasalah",
                "desc"=>"Inovasi pendekatan pemecahan masalah",
                "ref"=>ORMInovasiPemecahanMasalah::class,
            ],
            [
                "name"=>"SotaKebaharuan",
                "desc"=>"State of the art dan kebaruan",
                "ref"=>ORMSotaKebaharuan::class,
            ],
            [
                "name"=>"RoadmapPenelitian",
                "desc"=>"Akurasi peta jalan (roadmap) penelitian",
                "ref"=>ORMRoadmapPenelitian::class,
            ],
        ],
        "Metode" => [
            [
                "name"=>"AkurasiPenelitian",
                "desc"=>"Akurasi metode penelitian",
                "ref"=>ORMAkurasiPenelitian::class,
            ],
            [
                "name"=>"KejelasanPembagianTugasTim",
                "desc"=>"Kejelasan pembagian tugas tim peneliti",
                "ref"=>ORMKejelasanPembagianTugasTim::class,
            ],
            [
                "name"=>"KesesuaianWaktuRabLuaranFasilitas",
                "desc"=>"Kesesuaian metode dengan waktu, RAB, luaran dan fasilitas",
                "ref"=>ORMKesesuaianWaktuRabLuaranFasilitas::class,
            ],
            [
                "name"=>"PotensiKetercapaianLuaranDijanjikan",
                "desc"=>"Potensi ketercapaian luaran yang dijanjikan",
                "ref"=>ORMPotensiKetercapaianLuaranDijanjikan::class,
            ],
            [
                "name"=>"ModelFeasibilityStudy",
                "desc"=>"Desain prototipe/model dan Feasibility Study",
                "ref"=>ORMModelFeasibilityStudy::class,
            ],
            [
                "name"=>"KesesuaianTkt",
                "desc"=>"Kesesuaian target TKT",
                "ref"=>ORMKesesuaianTkt::class,
            ],
            [
                "name"=>"KredibilitasMitraDukungan",
                "desc"=>"Kredibilitas mitra dan bentuk dukungan",
                "ref"=>ORMKredibilitasMitraDukungan::class,
            ],
            [
                "name"=>"KebaruanReferensi",
                "desc"=>"Kebaruan referensi",
                "ref"=>ORMKebaruanReferensi::class,
            ],
            [
                "name"=>"RelevansiKualitasReferensi",
                "desc"=>"Relevansi dan kualitas referensi",
                "ref"=>ORMRelevansiKualitasReferensi::class,
            ],
        ],
    ];
    public $listMapSubstansiPkm=[
        "Rekam Jejak"=>[
            [
                "name"=>"KualitasKuantitasPublikasiJurnalIlmiah",
                "desc"=>"Kualitas dan kuantitas publikasi artikel di jurnal ilmiah",
                "ref"=>ORMKualitasKuantitasPublikasiJurnalIlmiah::class,
            ],
            [
                "name"=>"KualitasKuantitasPublikasiProsiding",
                "desc"=>"Kualitas dan kuantitas publikasi dalam prosiding",
                "ref"=>ORMKualitasKuantitasPublikasiProsiding::class,
            ],
            [
                "name"=>"KuantitasStatusKI",
                "desc"=>"Kuantitas dan status perolehan KI",
                "ref"=>ORMKuantitasStatusKI::class,
            ],
        ],
        "Usulan Pengabdian"=>[
            [
                "name"=>"KetajamanAnalisis",
                "desc"=>"Ketajaman analisis situasi permasalahan mitra sasaran",
                "ref"=>ORMKetajamanAnalisis::class,
            ],
            [
                "name"=>"RumusanPrioritasMitra",
                "desc"=>"Rumusan masalah prioritas mitra",
                "ref"=>ORMRumusanPrioritasMitra::class,
            ],
            [
                "name"=>"KesesuaianSolusiMasalahMitra",
                "desc"=>"Kesesuaian solusi dengan permasalahan mitra",
                "ref"=>ORMKesesuaianSolusiMasalahMitra::class,
            ],
            [
                "name"=>"MetodeRencanaKegiatan",
                "desc"=>"Metode dan rencana kegiatan yang ditawarkan",
                "ref"=>ORMMetodeRencanaKegiatan::class,
            ],
            [
                "name"=>"KesesuaianPenugasan",
                "desc"=>"Kesesuaian penugasan, kompetensi tim pelaksana dan mahasiswa",
                "ref"=>ORMKesesuaianPenugasan::class,
            ],
            [
                "name"=>"KualitasIpteks",
                "desc"=>"Kualitas Ipteks yang ditawarkan (hasil penelitian)",
                "ref"=>ORMKualitasIpteks::class,
            ],
            [
                "name"=>"LuaranArtikel",
                "desc"=>"Luaran artikel jurnal atau prosiding seminar",
                "ref"=>ORMLuaranArtikel::class,
            ],
            [
                "name"=>"ArtikelMediaMassa",
                "desc"=>"Artikel media massa",
                "ref"=>ORMArtikelMediaMassa::class,
            ],
            [
                "name"=>"VideoKegiatan",
                "desc"=>"Video kegiatan",
                "ref"=>ORMVideoKegiatan::class,
            ],
            [
                "name"=>"PeningkatanKeberdayaanMitra",
                "desc"=>"Peningkatan level keberdayaan mitra",
                "ref"=>ORMPeningkatanKeberdayaanMitra::class,
            ],
            [
                "name"=>"KewajaranTahapanTarget",
                "desc"=>"Kewajaran tahapan target dan capaian luaran wajib",
                "ref"=>ORMKewajaranTahapanTarget::class,
            ],
            [
                "name"=>"KesesuaianJadwal",
                "desc"=>"Kesesuaian jadwal",
                "ref"=>ORMKesesuaianJadwal::class,
            ],
        ],
    ];

    public function GetListMapSubstansiInternal(){
        return $this->listMapSubstansiInternal;
    }
    public function GetListMapSubstansiPKM(){
        return $this->listMapSubstansiPkm;
    }
}
