<?php

namespace App;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use Auditable;

    public $table = 'assessments';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'school_profile_id',
        'component_1',
        'component_2',
        'component_3',
        'component_4',
        'component_5',
        'component_6',
        'component_7',
        'component_8',
        'component_9',
        'component_10',
        'component_11',
        'component_12',
        'component_13',
        'component_14',
        'component_15',
        'component_16',
        'component_17',
        'component_18',
        'component_19',
        'component_20',
        'component_21',
        'component_22',
        'component_23',
        'component_24',
        'component_25',
        'component_26',
        'component_27',
        'component_28',
        'component_29',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const COMPONENT_1_SELECT = [
        3 => 'sesuai dengan Laporan EDS dan hasil IPMLH.',
        2 => 'sesuai dengan Laporan EDS atau hasil IPMLH.',
        1 => 'tidak sesuai dengan Laporan EDS dan hasil IPMLH.',
    ];

    const COMPONENT_2_SELECT = [
        3 => 'kepala sekolah, dewan pendidik, komite sekolah, peserta didik, dan masyarakat.',
        2 => 'kepala sekolah, dewan pendidik, komite sekolah dan peserta didik.',
        1 => 'kepala sekolah, dewan pendidik dan komite sekolah.',
    ];

    const COMPONENT_3_SELECT = [
        3 => 'visi, misi, tujuan sekolah dan Program Pengembangan Diri.',
        2 => 'visi,	misi dan tujuan sekolah	 atau Program   pengembangan Diri.',
        1 => 'visi, misi, tujuan sekolah dan Program Pengembangan Diri tidak memuat.',
    ];

    const COMPONENT_4_SELECT = [
        5 => '≥ 5 aspek.',
        4 => '4 aspek.',
        3 => '3 aspek.',
        2 => '2 aspek.',
        1 => '1 aspek.',
    ];

    const COMPONENT_5_SELECT = [
        5 => '> 80%',
        4 => '> 60% - 80%',
        3 => '> 40% - 60%',
        2 => '> 20% - 40%',
        1 => '< 20%',
    ];

    const COMPONENT_6_SELECT = [
        5 => '4 unsur utama + ≥ 4 unsur tambahan.',
        4 => '4 unsur utama + 3 unsur tambahan.',
        3 => '4 unsur  utama  + 2 unsur tambahan.',
        2 => '4 unsur  utama  + 1 unsur tambahan.',
        1 => '≤ 4 unsur utama.',
    ];

    const COMPONENT_7_SELECT = [
        5 => '≥ 7 upaya.',
        4 => '6 upaya.',
        3 => '5 upaya.',
        2 => '4 upaya.',
        1 => '≤ 3 upaya.',
    ];

    const COMPONENT_8_SELECT = [
        3 => 'Sekolah bersih, sanitasi dan drainase berfungsi.',
        2 => 'Sekolah bersih, sanitasi atau drainase berfungsi.',
        1 => 'Sekolah bersih, atau sanitasi berfungsi atau drainase berfungsi.',
    ];

    const COMPONENT_9_SELECT = [
        5 => '≥ 7 upaya.',
        4 => '6 upaya.',
        3 => '5 upaya.',
        2 => '4 upaya.',
        1 => '≤ 3 upaya.',
    ];

    const COMPONENT_10_SELECT = [
        3 => '≥ 3 upaya.',
        2 => '2 upaya.',
        1 => '1 upaya.',
    ];

    const COMPONENT_11_SELECT = [
        3 => 'Peserta	didik	dan Kader Adiwiyata.',
        2 => 'Peserta	didik	atau Kader Adiwiyata.',
        1 => 'Petugas kebersihan.',
    ];

    const COMPONENT_12_SELECT = [
        5 => '> 80%',
        4 => '> 60% - 80%',
        3 => '> 40% - 60%',
        2 => '> 20% - 40%',
        1 => '≤ 20%',
    ];

    const COMPONENT_13_SELECT = [
        3 => 'Penanaman, pemeliharaan dan pembibitan.',
        2 => 'Penanaman	dan pemeliharaan.',
        1 => 'Penanaman.',
    ];

    const COMPONENT_14_SELECT = [
        5 => '≥ 5 unsur.',
        4 => '4 unsur.',
        3 => '3 unsur.',
        2 => '2 unsur.',
        1 => '1 unsur.',
    ];

    const COMPONENT_15_SELECT = [
        5 => '> 80%',
        4 => '> 60% - 80%',
        3 => '> 40% - 60%',
        2 => '> 20%-40%',
        1 => '≤ 20%',
    ];

    const COMPONENT_16_SELECT = [
        5 => '≥ 7 upaya.',
        4 => '6 upaya.',
        3 => '5 upaya.',
        2 => '4 upaya.',
        1 => '3 upaya.',
    ];

    const COMPONENT_17_SELECT = [
        5 => '≥ 7 upaya.',
        4 => '6 upaya.',
        3 => '5 upaya.',
        2 => '4 upaya.',
        1 => '3 upaya.',
    ];

    const COMPONENT_18_SELECT = [
        3 => '≥ 5 karya inovatif.',
        2 => '3 - 4 karya inovatif.',
        1 => '1 - 2 karya inovatif.',
    ];

    const COMPONENT_19_SELECT = [
        5 => '≥ 4 aksi.',
        4 => '3 aksi.',
        3 => '2 aksi.',
        2 => '1 aksi.',
        1 => 'tidak ada aksi.',
    ];

    const COMPONENT_20_SELECT = [
        3 => 'Lingkungan sekitar Sekolah bersih dan drainase berfungsi.',
        2 => 'Lingkungan sekitar Sekolah bersih dan fungsi drainase tidak berfungsi atau lingkungan sekitar Sekolah kurang bersih dan drainase berfungsi.',
        1 => 'Lingkungan sekitar Sekolah kurang bersih dan drainase tidak berfungsi..',
    ];

    const COMPONENT_21_SELECT = [
        3 => 'sampah terpilah dan terkelola dengan baik.',
        2 => 'Sampah terpilah namun tidak terkelola dengan baik.',
        1 => 'sampah tidak terpilah dan tidak terkelola dengan baik.',
    ];

    const COMPONENT_22_SELECT = [
        5 => '≥ 5 jejaring.',
        4 => '4 jejaring.',
        3 => '3 jejaring.',
        2 => '2 jejaring.',
        1 => '1 jejaring.',
    ];

    const COMPONENT_23_SELECT = [
        5 => '≥ 5 kegiatan.',
        4 => '4 kegiatan.',
        3 => '3 kegiatan.',
        2 => '2 kegiatan.',
        1 => '1 kegiatan.',
    ];

    const COMPONENT_24_SELECT = [
        3 => '≥ 5 media.',
        2 => '3 - 4 media.',
        1 => '1 - 2 media.',
    ];

    const COMPONENT_25_SELECT = [
        5 => '> 20%',
        4 => '> 15% - 20%',
        3 => '>10% - 15%',
        2 => '>5% - 10%',
        1 => '≤5%',
    ];

    const COMPONENT_26_SELECT = [
        5 => '≥ 5 kegiatan.',
        4 => '4 kegiatan.',
        3 => '3 kegiatan.',
        2 => '2 kegiatan.',
        1 => '1 kegiatan.',
    ];

    const COMPONENT_27_SELECT = [
        3 => '3 kali dalam 1 tahun.',
        2 => '2 kali dalam 1 tahun.',
        1 => '1 kali dalam 1 tahun.',
    ];

    const COMPONENT_28_SELECT = [
        5 => '> 80%',
        4 => '> 60% - 80%',
        3 => '> 40% - 60%',
        2 => '> 20% - 40%',
        1 => '< 20%',
    ];

    const COMPONENT_29_SELECT = [
        3 => 'melibatkan kepala sekolah,dewan pendidik,komite sekolah, peserta didik, dan masyarakat.',
        2 => 'Melibatkan kepala sekolah, dewan pendidik, komite sekolah dan peserta didik.',
        1 => 'Melibatkan kepala sekolah, dewan pendidik dan komite sekolah.',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function school_profile()
    {
        return $this->belongsTo(SchoolProfile::class);
    }

    public function getScoreAttribute()
    {
        $n = 0;

        for ($i = 1; $i <= 29; $i++) {
            $n += $this->attributes['component_' . $i];
        }

        return $n;
    }
}
