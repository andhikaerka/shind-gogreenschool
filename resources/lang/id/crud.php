<?php

return [
    'statistics' => [
        'title' => 'Statistik',
        'title_singular' => 'Statistik',
    ],
    'planning' => [
        'title' => 'Perencanaan',
        'title_singular' => 'Perencanaan',
    ],
    'account' => [
        'title' => 'Akun Pengguna',
        'title_singular' => 'Akun Pengguna',
    ],
    'workGroup' => [
        'title' => 'Nama Pokja',
        'title_singular' => 'Nama Pokja',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'school' => 'Sekolah',
            'school_helper' => '',
            'name' => 'Nama Pokja',
            'name_helper' => '',
            'work_group_name' => 'Nama Pokja',
            'work_group_name_helper' => '',
            'alias' => 'Nama Pokja',
            'alias_helper' => '',
            'description' => 'Uraian',
            'description_helper' => '',
            'field' => 'Bidang Kerja',
            'field_helper' => '',
            'aspect' => 'Aspek Terapan',
            'aspect_helper' => '',
            'tutor' => 'Guru Pembimbing',
            'tutor_helper' => 'Bisa input manual',
            'tutor_1' => 'Nama Guru Pembimbing 1',
            'tutor_1_helper' => '',
            'tutor_2' => 'Nama Guru Pembimbing 2',
            'tutor_2_helper' => '',
            'created_at' => 'Dibuat pada',
            'created_at_helper' => '',
            'updated_at' => 'Diperbarui pada',
            'updated_at_helper' => '',
            'deleted_at' => 'Dihapus pada',
            'deleted_at_helper' => '',
            'task' => 'Tugas Pokja',
            'task_helper' => '',
        ],
    ],
    'schoolProfile' => [
        'title' => 'Profil Sekolah',
        'title_singular' => 'Profil Sekolah',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'school' => 'Sekolah',
            'school_helper' => '',
            'year' => 'Tahun',
            'year_helper' => '',
            'created_at' => 'Dibuat pada',
            'created_at_helper' => '',
            'updated_at' => 'Diperbarui pada',
            'updated_at_helper' => '',
            'deleted_at' => 'Dihapus pada',
            'deleted_at_helper' => '',
        ],
    ],
    'school' => [
        'title' => 'Profil Sekolah',
        'title_singular' => 'Profil Sekolah',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'slug' => 'Slug',
            'slug_helper' => '',
            'name' => 'Nama Sekolah',
            'name_helper' => '',
            'level' => 'Tingkatan Sekolah',
            'level_helper' => '',
            'vision' => 'Visi Sekolah',
            'vision_helper' => '',
            'status' => 'Status Sekolah',
            'status_helper' => '',
            'address' => 'Alamat Lengkap',
            'address_helper' => '',
            'phone' => 'No. Telpon Aktif/HP',
            'phone_helper' => '',
            'email' => 'Alamat Email',
            'email_helper' => '',
            'total_students' => 'Jumlah Siswa',
            'total_students_helper' => '',
            'total_teachers' => 'Jumlah Guru',
            'total_teachers_helper' => '',
            'total_land_area' => 'Luas Lahan',
            'total_land_area_helper' => 'dalam meter persegi',
            'total_building_area' => 'Luas Bangunan',
            'total_building_area_helper' => 'dalam meter persegi',
            'logo' => 'Logo Sekolah',
            'photo' => 'Foto Sekolah',
            'photo_helper' => 'jenis file yang digunakan pdf',
            'created_at' => 'Dibuat pada',
            'created_at_helper' => '',
            'updated_at' => 'Diperbarui pada',
            'updated_at_helper' => '',
            'deleted_at' => 'Dihapus pada',
            'deleted_at_helper' => '',
            'city' => 'Kab/Kota',
            'city_helper' => '',
            'user' => 'Pengguna',
            'user_helper' => 'Pengguna',
            'environmental_status' => 'Status LH Sekolah',
            'environmental_status_helper' => '',
            'website' => 'Website',
            'website_helper' => 'diawali dengan http:// atau https://',
            'approval_condition' => 'Aproval Kondisi',
            'approval_condition_helper' => '',
            'approval_time' => 'Aproval Waktu',
            'approval_time_helper' => '',
        ],
    ],
    'infrastructure' => [
        'title' => 'Sarana Prasarana',
        'title_singular' => 'Sarana Prasarana',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'school' => 'Sekolah',
            'school_helper' => '',
            'year' => 'Tahun',
            'year_helper' => '',
            'name' => 'Nama Sarana Prasarana',
            'name_helper' => '',
            'aspect' => 'Aspek Terapan LH',
            'aspect_helper' => '',
            'total' => 'Jumlah',
            'total_helper' => '',
            'function' => 'Fungsi Untuk Lingkungan',
            'function_helper' => '',
            'photo' => 'Foto Sarpras',
            'photo_helper' => 'jenis file yang digunakan pdf',
            'created_at' => 'Dibuat pada',
            'created_at_helper' => '',
            'updated_at' => 'Diperbarui pada',
            'updated_at_helper' => '',
            'deleted_at' => 'Dihapus pada',
            'deleted_at_helper' => '',
            'work_group' => 'Pokja Kader Terkait',
            'work_group_helper' => '',
            'pic' => 'Penanggung Jawab',
            'pic_helper' => '',
        ],
    ],
    'disaster' => [
        'title' => 'Bencana Alam',
        'title_singular' => 'Bencana Alam',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'school' => 'Sekolah',
            'school_helper' => '',
            'year' => 'Tahun',
            'year_helper' => '',
            'threat' => 'Ancaman Bencana Alam di Sekolah',
            'threat_helper' => '',
            'potential' => 'Potensi Sekolah Terhadap Bencana',
            'potential_helper' => '',
            'anticipation' => 'Kegiatan Antisipasi Bencana',
            'anticipation_helper' => '',
            'vulnerability' => 'Kerentanan Warga Sekolah Terhadap Bencana',
            'vulnerability_helper' => '',
            'impact' => 'Dampak Bencana Alam yang Pernah Terjadi di Sekolah',
            'impact_helper' => '',
            'created_at' => 'Dibuat pada',
            'created_at_helper' => '',
            'updated_at' => 'Diperbarui pada',
            'updated_at_helper' => '',
            'deleted_at' => 'Dihapus pada',
            'deleted_at_helper' => '',
            'threats' => 'Ancaman Bencana Sekolah',
            'threats_helper' => 'Isi jika tidak ada di pilihan',
            'photo' => 'Foto Sumber Bencana & Dampak yang Pernah Terjadi dll.',
            'photo_helper' => 'jenis file yang digunakan pdf',
        ],
    ],
    'qualityReport' => [
        'title' => 'EDS - LH',
        'title_singular' => 'EDS - LH',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'school' => 'Sekolah',
            'school_helper' => '',
            'year' => 'Tahun',
            'year_helper' => '',
            'has_document' => 'Apakah Sekolah Memiliki EDS LH Terbaru?',
            'has_document_helper' => '',
            'document' => 'Sumber: EDS LH Sekolah',
            'document_helper' => 'pdf EDS LH terakhir',
            'waste_management' => 'Aspek Pengelolaan Sampah',
            'waste_management_helper' => '',
            'energy_conservation' => 'Efisiensi Energi',
            'energy_conservation_helper' => '',
            'life_preservation' => 'Keanekaragaman Hayati',
            'life_preservation_helper' => '',
            'water_conservation' => 'Pelestarian Air',
            'water_conservation_helper' => '',
            'canteen_management' => 'Kantin Sehat',
            'canteen_management_helper' => '',
            'letter' => 'Dok. Penjabaran EDS LH Sekolah Terbaru',
            'letter_helper' => 'pdf sk EDS LH penjabaran kegiatan',
            'created_at' => 'Dibuat pada',
            'created_at_helper' => '',
            'updated_at' => 'Diperbarui pada',
            'updated_at_helper' => '',
            'deleted_at' => 'Dihapus pada',
            'deleted_at_helper' => '',
        ],
    ],
    'environment' => [
        'title' => 'EDS - LH',
        'title_singular' => 'EDS - LH',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'school' => 'Sekolah',
            'school_helper' => '',
            'year' => 'Tahun',
            'year_helper' => '',
            'compiler' => 'Penyusun',
            'compiler_helper' => '',
            'isi' => 'Standar Isi',
            'isi_helper' => '',
            'proses' => 'Standar Proses',
            'proses_helper' => '',
            'kompetensi_kelulusan' => 'Standar Kompetensi Kelulusan',
            'kompetensi_kelulusan_helper' => '',
            'pendidik_dan_tenaga_kependidikan' => 'Standar Pendidikan dan Tenaga Kependidikan',
            'pendidik_dan_tenaga_kependidikan_helper' => '',
            'sarana_prasarana' => 'Standar Sarana Prasarana',
            'sarana_prasarana_helper' => '',
            'pengelolaan' => 'Standar Pengelolaan',
            'pengelolaan_helper' => '',
            'pembiayaan' => 'Standar Pembiayaan',
            'pembiayaan_helper' => '',
            'penilaian_pendidikan' => 'Standar Penilaian Pendidikan',
            'penilaian_pendidikan_helper' => '',
            'file' => 'Dok. EDS LH Sekolah Terbaru',
            'file_helper' => 'Upload SK EDS Aspek Lingkungan Hidup Sekolah Terbaru',
            'created_at' => 'Dibuat pada',
            'created_at_helper' => '',
            'updated_at' => 'Diperbarui pada',
            'updated_at_helper' => '',
            'deleted_at' => 'Dihapus pada',
            'deleted_at_helper' => '',
        ],
    ],
    'team' => [
        'title' => 'Tim LH Sekolah',
        'title_singular' => 'Tim LH Sekolah',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'school' => 'Sekolah',
            'school_helper' => '',
            'year' => 'Tahun',
            'year_helper' => '',
            'name' => 'Nama Lengkap',
            'name_helper' => '',
            'team_status' => 'Status',
            'team_status_helper' => '',
            'gender' => 'Jenis Kelamin',
            'gender_helper' => '',
            'birth_date' => 'Tanggal Lahir',
            'birth_date_helper' => '',
            'age' => 'Usia',
            'age_helper' => '',
            'aspect' => 'Aspek Lingkungan',
            'aspect_helper' => '',
            'work_group' => 'Pokja Kader Terkait',
            'work_group_helper' => '',
            'job_description' => 'Tugas Pokok Kerja',
            'job_description_helper' => '',
            'team_position' => 'Jabatan',
            'team_position_helper' => '',
            'another_position' => 'Jabatan Lainnya',
            'another_position_helper' => '',
            'document' => 'SK/MOU Tim',
            'document_helper' => 'jenis file yang digunakan pdf',
            'created_at' => 'Dibuat pada',
            'created_at_helper' => '',
            'updated_at' => 'Diperbarui pada',
            'updated_at_helper' => '',
            'deleted_at' => 'Dihapus pada',
            'deleted_at_helper' => '',
            'user' => 'Pengguna',
            'user_helper' => '',
        ],
    ],
    'study' => [
        'title' => 'IPMLH Sekolah',
        'title_singular' => 'IPMLH Sekolah',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'quality_report' => 'Sumber: Raport Mutu Sekolah',
            'quality_report_helper' => '',
            'self_development' => 'Pengembangan Diri',
            'self_development_helper' => '',
            'environment_id' => 'EDS - Aspek Lingkungan Hidup Sekolah',
            'environment_id_helper' => '',
            'environmental_issue_id' => 'Isu Lingkungan',
            'environmental_issue_id_helper' => '',
            'aspect' => 'Aspek Terapan LH Sekolah',
            'aspect_helper' => '',
            'work_group' => 'Nama Pokja',
            'work_group_helper' => '',
            'snp_category' => 'Kategori 8 SNP',
            'snp_category_helper' => '',
            'potential' => 'Potensi LH Sekolah',
            'potential_helper' => '',
            'problem' => 'Permasalahan LH Sekolah',
            'problem_helper' => '',
            'activity' => 'Bentuk Program Kegiatan',
            'activity_helper' => '',
            'behavioral' => 'Output Perubahan Perilaku',
            'behavioral_helper' => '',
            'physical' => 'Target Perubahan Phisik',
            'physical_helper' => '',
            'kbm' => 'KBM yang Terintegrasi',
            'kbm_helper' => '',
            'artwork' => 'Hasil Karya Siswa Terkait',
            'artwork_helper' => '',
            'period' => 'Waktu Penyelesaian',
            'period_helper' => '',
            'lesson_plan_id' => 'RPP LH',
            'lesson_plan_id_helper' => '',
            'budget_plan_id' => 'RAKS LH',
            'budget_plan_id_helper' => '',
            'source' => 'Sumber RAB/Biaya',
            'source_helper' => '',
            'cost' => 'RAB/Biaya',
            'cost_helper' => '',
            'partner' => 'Mitra Kerja untuk Program ini',
            'partner_helper' => '',
            'percentage' => 'Prosentase % Pencapaian Program',
            'percentage_helper' => '',
            'team_statuses' => 'Penyusun IPMLH',
            'team_statuses_helper' => '',
            'created_at' => 'Dibuat pada',
            'created_at_helper' => '',
            'updated_at' => 'Diperbarui pada',
            'updated_at_helper' => '',
            'deleted_at' => 'Dihapus pada',
            'deleted_at_helper' => '',
            'checklist_templates' => 'Checklist',
            'checklist_templates_helper' => '',
        ],
    ],
    'curriculum' => [
        'title' => 'KTSP',
        'title_singular' => 'KTSP',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'school' => 'Sekolah',
            'school_helper' => '',
            'year' => 'Tahun',
            'year_helper' => '',
            'vision' => 'Visi',
            'vision_helper' => '',
            'mission' => 'Misi',
            'mission_helper' => '',
            'purpose' => 'Tujuan',
            'purpose_helper' => '',
            'calendars' => 'Kalender Pendidikan',
            'calendars_helper' => '',
            'document' => 'Dokumen KTSP',
            'document_helper' => '',
            'created_at' => 'Dibuat pada',
            'created_at_helper' => '',
            'updated_at' => 'Diperbarui pada',
            'updated_at_helper' => '',
            'deleted_at' => 'Dihapus pada',
            'deleted_at_helper' => '',
        ],
    ],
    'lessonPlan' => [
        'title' => 'RPP - LH',
        'title_singular' => 'RPP - LH',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'school' => 'Sekolah',
            'school_helper' => '',
            'year' => 'Tahun',
            'year_helper' => '',
            'environmental_issue_id' => 'Isu Lingkungan',
            'environmental_issue_id_helper' => '',
            'subject' => 'Nama Mapel',
            'subject_helper' => '',
            'teacher' => 'Nama Guru Mapel',
            'teacher_helper' => '',
            'class' => 'Kelas',
            'class_helper' => '',
            'period' => 'Periode',
            'period_helper' => '',
            'aspect' => 'Aspek Terapan',
            'aspect_helper' => '',
            'hook' => 'Kd Mengait',
            'hook_helper' => '',
            'artwork' => 'Hasil Karya Siswa',
            'artwork_helper' => '',
            'hour' => 'Jumlah Jam Belajar',
            'hour_helper' => '',
            'rpp' => 'Dokumen KBM',
            'rpp_helper' => 'jenis file yang digunakan pdf',
            'syllabus' => 'Silabus RPP',
            'syllabus_helper' => 'jenis file yang digunakan pdf',
            'created_at' => 'Dibuat pada',
            'created_at_helper' => '',
            'updated_at' => 'Diperbarui pada',
            'updated_at_helper' => '',
            'deleted_at' => 'Dihapus pada',
            'deleted_at_helper' => '',
        ],
    ],
    'budgetPlan' => [
        'title' => 'RAKS LH',
        'title_singular' => 'RAKS LH',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'school' => 'Sekolah',
            'school_helper' => '',
            'year' => 'Tahun',
            'year_helper' => '',
            'aspect' => 'Nama Aspek Terapan',
            'aspect_helper' => '',
            'description' => 'Uraian Belanja',
            'description_helper' => '',
            'cost' => 'Jumlah Biaya',
            'cost_helper' => '',
            'snp_category' => 'Kategori 8 SNP',
            'snp_category_helper' => '',
            'source' => 'Sumber Anggaran',
            'source_helper' => '',
            'pic' => 'Penanggung Jawab',
            'pic_helper' => '',
            'created_at' => 'Dibuat pada',
            'created_at_helper' => '',
            'updated_at' => 'Diperbarui pada',
            'updated_at_helper' => '',
            'deleted_at' => 'Dihapus pada',
            'deleted_at_helper' => '',
        ],
    ],
    'partner' => [
        'title' => 'Kemitraan',
        'title_singular' => 'Kemitraan',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'school' => 'Sekolah',
            'school_helper' => '',
            'year' => 'Tahun',
            'year_helper' => '',
            'name' => 'Nama Mitra',
            'name_helper' => '',
            'cp_name' => 'Kontak Person Mitra',
            'cp_name_helper' => '',
            'cp_phone' => 'Kontak Person Mitra',
            'cp_phone_helper' => '',
            'partner_category' => 'Kategori',
            'partner_category_helper' => '',
            'partner_activity' => 'Kegiatan',
            'partner_activity_helper' => 'Kegiatan lainnya: isi manual',
            'date' => 'Waktu',
            'date_helper' => '',
            'purpose' => 'Tujuan',
            'purpose_helper' => '',
            'total_people' => 'Jumlah Peserta',
            'total_people_helper' => '',
            'photo' => 'Foto Dokumen',
            'photo_helper' => 'jenis file yang digunakan pdf',
            'created_at' => 'Dibuat pada',
            'created_at_helper' => '',
            'updated_at' => 'Diperbarui pada',
            'updated_at_helper' => '',
            'deleted_at' => 'Dihapus pada',
            'deleted_at_helper' => '',
        ],
    ],
    'cadre' => [
        'title' => 'Kader Siswa',
        'title_singular' => 'Kader Siswa',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'year' => 'Tahun',
            'year_helper' => '',
            'name' => 'Nama Lengkap',
            'name_helper' => '',
            'work_group' => 'Kelompok Kerja',
            'work_group_helper' => '',
            'gender' => 'Jenis Kelamin',
            'gender_helper' => '',
            'birth_date' => 'Tgl Lahir',
            'birth_date_helper' => '',
            'phone' => 'No Telpon Aktif/HP',
            'phone_helper' => '',
            'class' => 'Kelas Sekarang',
            'class_helper' => '',
            'address' => 'Alamat Rumah',
            'address_helper' => '',
            'hobby' => 'Hobi/Minat',
            'hobby_helper' => '',
            'position' => 'Jabatan di Pokja',
            'position_helper' => 'Lainnya isi manual..',
            'letter' => 'SK/Surat Ijin Ortu',
            'letter_helper' => '',
            'photo' => 'Foto Saat Ini',
            'photo_helper' => 'jenis file yang digunakan jpeg (jpg)',
            'created_at' => 'Dibuat pada',
            'created_at_helper' => '',
            'updated_at' => 'Diperbarui pada',
            'updated_at_helper' => '',
            'deleted_at' => 'Dihapus pada',
            'deleted_at_helper' => '',
            'user' => 'Pengguna',
            'user_helper' => '',
            'age' => 'Umur',
            'age_helper' => '',
        ],
    ],
    'workProgram' => [
        'title' => 'Proker Kader',
        'title_singular' => 'Proker Kader',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'name' => 'Nama Proker',
            'name_helper' => '',
            'work_group' => 'Nama Pokja',
            'work_group_helper' => '',
            'aspect' => 'Aspek Program LH Sekolah',
            'aspect_helper' => '',
            'study' => 'Analisa Awal',
            'study_helper' => '',
            'condition' => 'Kondisi Sarana Prasarana Saat Ini',
            'condition_helper' => '',
            'plan' => 'Rencana Aksi Kader',
            'plan_helper' => '',
            'activity' => 'Bentuk Kegiatan Pokja',
            'activity_helper' => '',
            'percentage' => 'Prosentase % Pencapaian',
            'percentage_helper' => '',
            'time' => 'Target Waktu Penyelesaian',
            'time_helper' => '',
            'tutor' => 'Guru Pembimbing',
            'tutor_helper' => '',
            'tutor_1' => 'Guru Pembimbing 1',
            'tutor_1_helper' => '',
            'tutor_2' => 'Guru Pembimbing 2',
            'tutor_2_helper' => '',
            'tutor_3' => 'Guru Pembimbing 3',
            'tutor_3_helper' => '',
            'photo' => 'Foto Dokumen Terkait',
            'photo_helper' => 'Min 4 foto diberi keterangan, atau dok pendukung lainnya dan jenis file yang digunakan pdf',
            'featured' => 'Apakah Program Ini Unggulan LH Sekolah?',
            'featured_helper' => '',
            'innovation' => 'Apakah Program Ini Inovasi Sekolah?',
            'innovation_helper' => '',
            'created_at' => 'Dibuat pada',
            'created_at_helper' => '',
            'updated_at' => 'Diperbarui pada',
            'updated_at_helper' => '',
            'deleted_at' => 'Dihapus pada',
            'deleted_at_helper' => '',
        ],
    ],
    'innovation' => [
        'title' => 'Inovasi LH',
        'title_singular' => 'Inovasi LH',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'name' => 'Nama Program',
            'name_helper' => '',
            'aspect' => 'Aspek Terapan',
            'aspect_helper' => '',
            'work_group' => 'Pokja Pelaksana',
            'work_group_helper' => '',
            'activity' => 'Bentuk Kegiatan',
            'activity_helper' => '',
            'tutor' => 'Guru Pembimbing',
            'tutor_helper' => '',
            'purpose' => 'Tujuan Program',
            'purpose_helper' => '',
            'team_statuses' => 'Pihak yang Terlibat',
            'team_statuses_helper' => '',
            'advantage' => 'Manfaat bagi lingkungan hidup',
            'advantage_helper' => '',
            'innovation' => 'Keunggulan dan Inovasi',
            'innovation_helper' => '',
            'photo' => 'Dokumen dan Foto',
            'photo_helper' => 'Min 4 foto diberi keterangan, atau dok pendukung lainnya dan jenis file yang digunakan pdf',
            'created_at' => 'Dibuat pada',
            'created_at_helper' => '',
            'updated_at' => 'Diperbarui pada',
            'updated_at_helper' => '',
            'deleted_at' => 'Dihapus pada',
            'deleted_at_helper' => '',
        ],
    ],
    'thisYearActionPlan' => [
        'title' => 'Cetak 1 Tahun',
        'title_singular' => 'Cetak 1 Tahun',
    ],
    'nextYearActionPlan' => [
        'title' => 'Cetak 4 Tahun',
        'title_singular' => 'Cetak 4 Tahun',
    ],
    /////////////////////////////////////////////////////////////////////////////////////////////////////
    'implementationActivity' => [
        'title' => 'Pelaksanaan',
        'title_singular' => 'Pelaksanaan',
    ],
    'inputCadre' => [
        'title' => 'Input Kader',
        'title_singular' => 'Input Kader',
    ],
    'cadreActivity' => [
        'title' => 'Kegiatan Pokja',
        'title_singular' => 'Kegiatan Pokja',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'year' => 'Tahun',
            'year_helper' => '',
            'date' => 'Tanggal Kegiatan',
            'date_helper' => '',
            'work_group' => 'Nama Pokja Siswa',
            'work_group_helper' => '',
            'work_program' => 'Kegiatan Pokja',
            'work_program_helper' => '',
            'self_development' => 'Pengembangan Diri',
            'self_development_helper' => '',
            'condition' => 'Kondisi Kegiatan (%)',
            'condition_helper' => '',
            'percentage' => 'Kondisi Kegiatan (%)',
            'percentage_helper' => '',
            'results' => 'Hasil Kegiatan',
            'results_helper' => '',
            'problem' => 'Kendala/Masalah',
            'problem_helper' => '',
            'behavioral' => 'Perubahan Perilaku Sekarang',
            'behavioral_helper' => '',
            'physical' => 'Perubahan Phisik Sekarang',
            'physical_helper' => '',
            'plan' => 'Rencana Tindak Lanjut Penyelesaian',
            'plan_helper' => '',
            'team_statuses' => 'Pihak Terlibat',
            'team_statuses_helper' => '',
            'tutor' => 'Guru Pembimbing',
            'tutor_helper' => '',
            'document' => 'Dok & Foto',
            'document_helper' => 'Min 4 foto diberi keterangan, atau dok pendukung lainnya dan jenis file yang digunakan pdf',
            'created_at' => 'Dibuat pada',
            'created_at_helper' => '',
            'updated_at' => 'Diperbarui pada',
            'updated_at_helper' => '',
            'deleted_at' => 'Dihapus pada',
            'deleted_at_helper' => '',
        ],
    ],
    'activity' => [
        'title' => 'Kegiatan Baru',
        'title_singular' => 'Kegiatan Baru',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'name' => 'Nama Kegiatan',
            'name_helper' => '',
            'date' => 'Tanggal Kegiatan',
            'date_helper' => '',
            'aspect' => 'Aspek Terapan',
            'aspect_helper' => '',
            'work_group' => 'Nama Pokja Siswa',
            'work_group_helper' => '',
            'activity' => 'Bentuk Kegiatan',
            'activity_helper' => '',
            'advantage' => 'Manfaat Bagi Sekolah',
            'advantage_helper' => '',
            'behavioral' => 'Perubahan Perilaku',
            'behavioral_helper' => '',
            'physical' => 'Perubahan Phisik',
            'physical_helper' => '',
            'team_status' => 'Pihak Terlibat',
            'team_status_helper' => '',
            'tutor' => 'Guru Pembimbing',
            'tutor_helper' => '',
            'document' => 'Dok & Foto',
            'document_helper' => 'Min 4 foto diberi keterangan, atau dok pendukung lainnya dan jenis file yang digunakan pdf',
            'created_at' => 'Dibuat pada',
            'created_at_helper' => '',
            'updated_at' => 'Diperbarui pada',
            'updated_at_helper' => '',
            'deleted_at' => 'Dihapus pada',
            'deleted_at_helper' => '',
        ],
    ],
    /*'activityImplementation' => [
    'title' => 'Pelaksanaan Kegiatan',
    'title_singular' => 'Pelaksanaan Kegiatan',
    'fields' => [
    'id' => 'ID',
    'id_helper' => '',
    'school' => 'Sekolah',
    'school_helper' => '',
    'date' => 'Waktu',
    'date_helper' => '',
    'work_group' => 'Pokja',
    'work_group_helper' => '',
    'activity' => 'Kegiatan',
    'activity_helper' => '',
    'progress' => 'Input Progres',
    'progress_helper' => '',
    'constraints' => 'Kendala',
    'constraints_helper' => '',
    'plan' => 'Rencana Tindak Lanjut',
    'plan_helper' => '',
    'document' => 'Upload Dokumen',
    'document_helper' => '',
    'created_at' => 'Dibuat pada',
    'created_at_helper' => '',
    'updated_at' => 'Diperbarui pada',
    'updated_at_helper' => '',
    'deleted_at' => 'Dihapus pada',
    'deleted_at_helper' => '',
    ],
    ],
    'thisYearActivityImplementation' => [
    'title' => 'Pelaksanaan Aksi LH Tahun Ini',
    'title_singular' => 'Rencana Aksi Lingkungan Tahun Ini',
    ],
    'nextYearActivityImplementation' => [
    'title' => 'Pelaksanaan Aksi LH Mendatang (RPJM 4 TH)',
    'title_singular' => 'Rencana Aksi Lingkungan Mendatang',
    ],*/
    /////////////////////////////////////////////////////////////////////////////////////////////////////
    'monitoringAndEvaluation' => [
        'title' => 'Monev',
        'title_singular' => 'Monev',
    ],
    'monitor' => [
        'title' => 'Monitoring',
        'title_singular' => 'Monitoring',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'date' => 'Waktu',
            'date_helper' => '',
            'aspect' => 'Aspek Terapan',
            'aspect_helper' => '',
            'work_group' => 'Nama Pokja',
            'work_group_helper' => '',
            'team_statuses' => 'Pihak Terkait',
            'team_statuses_helper' => '',
            'document' => 'Dok & Foto Monitoring',
            'document_helper' => 'Min 4 foto diberi keterangan, atau dok pendukung lainnya dan jenis file yang digunakan pdf',
            'created_at' => 'Dibuat pada',
            'created_at_helper' => '',
            'updated_at' => 'Diperbarui pada',
            'updated_at_helper' => '',
            'deleted_at' => 'Dihapus pada',
            'deleted_at_helper' => '',
        ],
    ],
    'recommendation' => [
        'title' => 'Rekomendasi',
        'title_singular' => 'Rekomendasi',
        'fields' => [
            'cadre_activity' => 'Nama Pokja',
            'cadre_activity_helper' => '',
        ],
    ],
    'evaluation' => [
        'title' => 'Evaluasi',
        'title_singular' => 'Evaluasi',
    ],
    /*'movementRecommendation' => [
    'title' => 'Rekomendasi Akhir Gerakan LH',
    'title_singular' => 'Rekomendasi Akhir Gerakan LH',
    ],*/
    /////////////////////////////////////////////////////////////////////////////////////////////////////
    'verification' => [
        'title' => 'Verifikasi',
        'title_singular' => 'Verifikasi',
    ],
    'assessment' => [
        'title' => 'Penilaian',
        'title_singular' => 'Penilaian',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'school' => 'Sekolah',
            'school_helper' => '',
            'school_profile' => 'Sekolah',
            'school_profile_helper' => '',
            'component_1' => 'Rencana Gerakan PBLHS disusun berdasarkan Laporan EDS dan hasil IPMLH',
            'component_1_helper' => 'Kesesuaian Rencana Gerakan PBLHS dengan Laporan EDS dan hasil IPMLH.',
            'component_1_links' => [
                'EDS' => [
                    'path' => 'quality-reports'
                ],
                'IPMLH' => [
                    'path' => 'studies'
                ],
            ],
            'component_2' => 'Penyusunan Rencana Gerakan PBLHS melibatkan kepala sekolah,dewan pendidik,komite sekolah,peserta didik, dan masyarakat',
            'component_2_helper' => 'Pihak yang terlibat dalam penyusunan dokumen Rencana Gerakan PBLHS.',
            'component_2_links' => [
                'Tim LH Sekolah' => [
                    'path' => 'teams'
                ],
            ],
            'component_3' => 'Rencana Gerakan PBLHS terintegrasi dalam dokumen Satu KTSP.',
            'component_3_helper' => 'Rencana Gerakan PBLHS terintegrasi dalam dokumen Satu KTSP.',
            'component_3_links' => [
                'KTSP' => [
                    'path' => 'curricula'
                ],
            ],
            'component_4' => 'Rencana Gerakan PBLHS terintegrasi dalam RPP :',
            'component_4_helper' => '1. jumlah aspek penerapan PRLH yang diintegrasikan dalam RPP.',
            'component_4_links' => [
                'Nama Pokja' => [
                    'path' => 'work-groups'
                ],
            ],
            'component_5' => '',
            'component_5_helper' => '2. % RPP yang mengintegrasikan aspek Penerapan PRLH.',
            'component_5_links' => [
                'RPP' => [
                    'path' => 'lesson-plans'
                ],
            ],
            'component_6' => 'Pembelajaran pada mata pelajaran, ekstrakurikuler dan pembiasaan diri yang mengintegrasikan Penerapan PRLH di Sekolah',
            'component_6_helper' => '<strong>Kebersihan, fungsi sanitasi, dan drainase.</strong><br>1. jumlah unsur warga sekolah yang berpartisipasi dalam kegiatan kebersihan, fungsi sanitasi dan drainase Sekolah.',
            'component_6_links' => [
                'Tim LH Sekolah' => [
                    'path' => 'teams'
                ],
                'Pokja drainase sekolah' => [
                    'path' => 'work-groups',
                    'query' => [
                        'work_group_name_id' => 13
                    ]
                ],
            ],
            'component_7' => '',
            'component_7_helper' => '2. Jumlah upaya pemeliharaan kebersihan,fungsi sanitasi dan drainase Sekolah',
            'component_7_links' => [
                'EDS' => [
                    'path' => 'quality-reports'
                ],
                'IPMLH' => [
                    'path' => 'studies'
                ],
                'Proker Kader drainase sekolah' => [
                    'path' => 'work-programs',
                    'query' => [
                        'work_group_name_id' => 13
                    ]
                ],
            ],
            'component_8' => '',
            'component_8_helper' => '3. Terpeliharanya kebersihan, fungsi sanitasi dan drainase Sekolah.',
            'component_8_links' => [
                'Proker Kader drainase sekolah' => [
                    'path' => 'work-programs',
                    'query' => [
                        'work_group_name_id' => 13
                    ]
                ],
                'Kegiatan kader pokja drainase sekolah' => [
                    'path' => 'cadre-activities',
                    'query' => [
                        'work_group_name_id' => 13
                    ]
                ],
            ],
            'component_9' => '',
            'component_9_helper' => '<strong>b. pengelolaan sampah.</strong><br>1. jumlah upaya pengurangan timbulan sampah dan penggunaan ulang barang/sampah (Reduce dan Reuse).',
            'component_9_links' => [
                'IPMLH' => [
                    'path' => 'studies'
                ],
                'Proker Kader Bank Sampah' => [
                    'path' => 'work-programs',
                    'query' => [
                        'work_group_name_id' => 3
                    ]
                ],
                'Proker Kader Komposting' => [
                    'path' => 'work-programs',
                    'query' => [
                        'work_group_name_id' => 1
                    ]
                ],
                'Proker Kader Kerajinan daur ulang 3r' => [
                    'path' => 'work-programs',
                    'query' => [
                        'work_group_name_id' => 2
                    ]
                ],
                'Kegiatan kader Pokja bak sampah' => [
                    'path' => 'cadre-activities',
                    'query' => [
                        'work_group_name_id' => 3
                    ]
                ],
                'Kegiatan Pokja Komposting' => [
                    'path' => 'cadre-activities',
                    'query' => [
                        'work_group_name_id' => 1
                    ]
                ],
                'Kegiatan Pokja daur ulang 3R' => [
                    'path' => 'cadre-activities',
                    'query' => [
                        'work_group_name_id' => 2
                    ]
                ],
            ],
            'component_10' => '',
            'component_10_helper' => '2. Jumlah upaya daur ulang sampah.',
            'component_10_links' => [
                'IPMLH' => [
                    'path' => 'studies'
                ],
                'Proker Kader Bank Sampah' => [
                    'path' => 'work-programs',
                    'query' => [
                        'work_group_name_id' => 3
                    ]
                ],
                'Proker Kader Kerajinan Daur Ulang (3R)' => [
                    'path' => 'work-programs',
                    'query' => [
                        'work_group_name_id' => 2
                    ]
                ],
                'Proker Kader pokja Komposting' => [
                    'path' => 'work-programs',
                    'query' => [
                        'work_group_name_id' => 1
                    ]
                ],
            ],
            'component_11' => '',
            'component_11_helper' => '3. Pelibatan peserta diidik dan Kader Adiwiyata, dalam pemindahan sampah dari sumber ke tempat pengelolaan sampah di Sekolah (bank sampah, tempat pengomposan, dll.)',
            'component_11_links' => [
                'IPMLH' => [
                    'path' => 'studies'
                ],
                'Proker Kader Bank Sampah' => [
                    'path' => 'work-programs',
                    'query' => [
                        'work_group_name_id' => 3
                    ]
                ],
                'Proker Kader Komposting' => [
                    'path' => 'work-programs',
                    'query' => [
                        'work_group_name_id' => 1
                    ]
                ],
                'Proker Kader Kerajinan daur ulang 3r' => [
                    'path' => 'work-programs',
                    'query' => [
                        'work_group_name_id' => 2
                    ]
                ],
                'Kegiatan kader Pokja bak sampah' => [
                    'path' => 'cadre-activities',
                    'query' => [
                        'work_group_name_id' => 3
                    ]
                ],
                'Kegiatan Pokja Komposting' => [
                    'path' => 'cadre-activities',
                    'query' => [
                        'work_group_name_id' => 1
                    ]
                ],
                'Kegiatan Pokja daur ulang 3R' => [
                    'path' => 'cadre-activities',
                    'query' => [
                        'work_group_name_id' => 2
                    ]
                ],
            ],
            'component_12' => '',
            'component_12_helper' => '4. % pengurangan timbulan sampah melalui 3R (Reduce, Reuse, Recycle).',
            'component_12_links' => [
                'Proker Kader Bank Sampah' => [
                    'path' => 'work-programs',
                    'query' => [
                        'work_group_name_id' => 3
                    ]
                ],
                'Proker Kader Komposting' => [
                    'path' => 'work-programs',
                    'query' => [
                        'work_group_name_id' => 1
                    ]
                ],
                'Proker Kader Kerajinan daur ulang 3r' => [
                    'path' => 'work-programs',
                    'query' => [
                        'work_group_name_id' => 2
                    ]
                ],
                'Kegiatan kader Pokja bak sampah' => [
                    'path' => 'cadre-activities',
                    'query' => [
                        'work_group_name_id' => 3
                    ]
                ],
                'Kegiatan Pokja Komposting' => [
                    'path' => 'cadre-activities',
                    'query' => [
                        'work_group_name_id' => 1
                    ]
                ],
                'Kegiatan Pokja daur ulang 3R' => [
                    'path' => 'cadre-activities',
                    'query' => [
                        'work_group_name_id' => 2
                    ]
                ],
            ],
            'component_13' => '',
            'component_13_helper' => '<strong>c. Penanaman dan pemeliharaan pohon/tanaman</strong><br>1. kegiatan penanaman, pemeliharaan dan pembibitan pohon/tanaman.',
            'component_13_links' => [
                'IPMLH' => [
                    'path' => 'studies'
                ],
                'Proker Kader Taman dan kolam,' => [
                    'path' => 'work-programs',
                    'query' => [
                        'work_group_name_id' => 7
                    ]
                ],
                'Proker kader Toga' => [
                    'path' => 'work-programs',
                    'query' => [
                        'work_group_name_id' => 8
                    ]
                ],
                'Proker Kader Greenhouse' => [
                    'path' => 'work-programs',
                    'query' => [
                        'work_group_name_id' => 9
                    ]
                ],
                'Proker Kebun & Hutan Sekolah' => [
                    'path' => 'work-programs',
                    'query' => [
                        'work_group_name_id' => 18
                    ]
                ],
                'Kegiatan kader taman dan kolam' => [
                    'path' => 'cadre-activities',
                    'query' => [
                        'work_group_name_id' => 7
                    ]
                ],
                'Kegiatan kader Greenhouse' => [
                    'path' => 'cadre-activities',
                    'query' => [
                        'work_group_name_id' => 9
                    ]
                ],
                'Kegiatan kader Toga' => [
                    'path' => 'cadre-activities',
                    'query' => [
                        'work_group_name_id' => 8
                    ]
                ],
                'Kegiatan Kader Kebun dan hutan sekolah' => [
                    'path' => 'cadre-activities',
                    'query' => [
                        'work_group_name_id' => 18
                    ]
                ],
            ],
            'component_14' => '',
            'component_14_helper' => '2. Jumlah unsur warga Sekolah yang berpartisipasi dalam kegiatan penanaman, pemeliharaan dan pembibitan pohon/tanaman.',
            'component_14_links' => [
                'Kemitraan' => [
                    'path' => 'partners',
                ],
            ],
            'component_15' => '',
            'component_15_helper' => '3. Jumlah pohon/tanaman yang ditanam dan dipelihara.',
            'component_15_links' => [
                'Proker Kader Taman dan kolam,' => [
                    'path' => 'work-programs',
                    'query' => [
                        'work_group_name_id' => 7
                    ]
                ],
                'Proker kader Toga' => [
                    'path' => 'work-programs',
                    'query' => [
                        'work_group_name_id' => 8
                    ]
                ],
                'Proker Kader Greenhouse' => [
                    'path' => 'work-programs',
                    'query' => [
                        'work_group_name_id' => 9
                    ]
                ],
                'Proker Kebun & Hutan Sekolah' => [
                    'path' => 'work-programs',
                    'query' => [
                        'work_group_name_id' => 18
                    ]
                ],
                'Kegiatan kader taman dan kolam' => [
                    'path' => 'cadre-activities',
                    'query' => [
                        'work_group_name_id' => 7
                    ]
                ],
                'Kegiatan kader Greenhouse' => [
                    'path' => 'cadre-activities',
                    'query' => [
                        'work_group_name_id' => 9
                    ]
                ],
                'Kegiatan kader Toga' => [
                    'path' => 'cadre-activities',
                    'query' => [
                        'work_group_name_id' => 8
                    ]
                ],
                'Kegiatan Kader Kebun dan hutan sekolah' => [
                    'path' => 'cadre-activities',
                    'query' => [
                        'work_group_name_id' => 18
                    ]
                ],
            ],
            'component_16' => '',
            'component_16_helper' => '<strong>D. Konservasi Air.</strong><br>jumlah upaya Konservasi Air.',
            'component_16_links' => [
                'IPMLH' => [
                    'path' => 'studies'
                ],
                'Proker Kader biopori' => [
                    'path' => 'work-programs',
                    'query' => [
                        'work_group_name_id' => 11
                    ]
                ],
                'Proker Kader Sanitasi Lingkungan' => [
                    'path' => 'work-programs',
                    'query' => [
                        'work_group_name_id' => 10
                    ]
                ],
                'Proker Drainase sekolah' => [
                    'path' => 'work-programs',
                    'query' => [
                        'work_group_name_id' => 13
                    ]
                ],
                'Proker kader sumur resapan' => [
                    'path' => 'work-programs',
                    'query' => [
                        'work_group_name_id' => 12
                    ]
                ],
                'Kegiatan Kader Pokja biopori' => [
                    'path' => 'cadre-activities',
                    'query' => [
                        'work_group_name_id' => 11
                    ]
                ],
                'Kegiatan Kader Pokja Sanitasi lingkungan' => [
                    'path' => 'cadre-activities',
                    'query' => [
                        'work_group_name_id' => 10
                    ]
                ],
                'Kegiatan Kader Pokja Drainase sekolah' => [
                    'path' => 'cadre-activities',
                    'query' => [
                        'work_group_name_id' => 13
                    ]
                ],
                'Kegiatan Kader pokja Sumur resapan' => [
                    'path' => 'cadre-activities',
                    'query' => [
                        'work_group_name_id' => 12
                    ]
                ],
            ],
            'component_17' => '',
            'component_17_helper' => '<strong>E. Konservasi Energi.</strong><br>jumlah upaya Konservasi Energi.',
            'component_17_links' => [
                'IPMLH' => [
                    'path' => 'studies'
                ],
                'Proker Kader Energi' => [
                    'path' => 'work-programs',
                    'query' => [
                        'work_group_name_id' => 5
                    ]
                ],
                'Kegiatan Kader energi' => [
                    'path' => 'cadre-activities',
                    'query' => [
                        'work_group_name_id' => 5
                    ]
                ],
            ],
            'component_18' => '',
            'component_18_helper' => '<strong>F. Inovasi terkait penerapan PRLH lainnya berdasarkan hasil IPMLH.</strong>jumlah karya inovatif pendidik dan peserta didik.',
            'component_18_links' => [
                'Inovasi sekolah' => [
                    'path' => 'innovations',
                ],
            ],
            'component_19' => '',
            'component_19_helper' => '<strong>2. Penerapan PRLH untuk masyarakat sekitar Sekolah dan/atau di daerah.</strong><br>1. jumlah aksi Penerapan PRLH untuk masyarakat sekitar Sekolah.',
            'component_19_links' => [
                'Kemitraan kategori Pemerintah Setempat' => [
                    'path' => 'partners',
                    'query' => [
                        'partner_category_id' => 2
                    ]
                ],
            ],
            'component_20' => '',
            'component_20_helper' => '2. Kebersihan dan fungsi drainase di lingkungan sekitar Sekolah',
            'component_20_links' => [
                'Kemitraan kategori Pemerintah Setempat' => [
                    'path' => 'partners',
                    'query' => [
                        'partner_category_id' => 2
                    ]
                ],
                'Kegiatan Kader Drainase sekolah' => [
                    'path' => 'cadre-activities',
                    'query' => [
                        'work_group_name_id' => 13
                    ]
                ],
                'Nama Pokja Dranaise sekolah' => [
                    'path' => 'work-groups',
                    'query' => [
                        'work_group_name_id' => 13
                    ]
                ],
            ],
            'component_21' => '',
            'component_21_helper' => '3. Pengelolaan sampah di lingkungan sekitar Sekolah.',
            'component_21_links' => [
                'Kemitraan kategori Pemerintah Setempat' => [
                    'path' => 'partners',
                    'query' => [
                        'partner_category_id' => 2
                    ]
                ],
                'Kegiatan Kader bank sampah' => [
                    'path' => 'cadre-activities',
                    'query' => [
                        'work_group_name_id' => 3
                    ]
                ],
                'Nama Pokja Bank Sampah' => [
                    'path' => 'work-groups',
                    'query' => [
                        'work_group_name_id' => 3
                    ]
                ],
            ],
            'component_22' => '',
            'component_22_helper' => '<strong>3. Membentuk jejaring kerja dan komunikasi.</strong><br>Jumlah jejaring kerja dan komunikasi (antar warga Sekolah, antar Sekolah dan dengan instansi/ pihak terkait).',
            'component_22_links' => [
                'Kemitraan' => [
                    'path' => 'partners',
                ],
            ],
            'component_23' => '',
            'component_23_helper' => '<strong>4. Kampanye dan publikasi Gerakan PBLHS.</strong><br>1. Jumlah kegiatan kampanye dan publikasi Gerakan PBLHS.',
            'component_23_links' => [
                'Kemitraan kategori Media Massa' => [
                    'path' => 'partners',
                    'query' => [
                        'partner_category_id' => 11
                    ]
                ],
            ],
            'component_24' => '',
            'component_24_helper' => '2. Jumlah media publikasi.',
            'component_24_links' => [
                'Kemitraan kategori media massa' => [
                    'path' => 'partners',
                    'query' => [
                        'partner_category_id' => 11
                    ]
                ],
            ],
            'component_25' => '',
            'component_25_helper' => '<strong>5. Membentuk dan memberdayakan Kader Adiwiyata.</strong><br>1. % Kader Adiwiyata yang dibentuk.',
            'component_25_links' => [
                'Dashboard' => [
                    'path' => 'dashboard',
                ],
                'Kader Siswa' => [
                    'path' => 'cadres',
                ],
            ],
            'component_26' => '',
            'component_26_helper' => '2. Jumlah kegiatan pemberdayaan Kader Adiwiyata.',
            'component_26_links' => [
                'Proker Kader' => [
                    'path' => 'work-programs',
                ],
                'Kegiatan Kader' => [
                    'path' => 'cadre-activities',
                ],
            ],
            'component_27' => 'Pemantauan & Evaluasi Gerakan PBLHS.',
            'component_27_helper' => '<strong>1. Melaksanakan pemantauan dan evaluasi pelaksanan gerakan PBLHS</strong><br>1. Frekuensi pelaksanaan pemantauan dan evaluasi.',
            'component_27_links' => [
                'Menu Monitoring' => [
                    'path' => 'monitors',
                ],
            ],
            'component_28' => '',
            'component_28_helper' => '2. % rencana kegiatan Gerakan PBLHS yang terlaksana.',
            'component_28_links' => [
                'Menu Monitoring' => [
                    'path' => 'monitors',
                ],
                'Menu Evaluasi' => [
                    'path' => 'evaluations',
                ],
                'Menu Rekomendasi' => [
                    'path' => 'recommendations',
                ],
            ],
            'component_29' => '',
            'component_29_helper' => '2. Pemantauan dan evaluasi melibatkan kepala sekolah, dewan pendidik, komite sekolah, peserta didik, dan masyarakat.',
            'component_29_links' => [
                'Menu Monitoring' => [
                    'path' => 'monitors',
                ],
            ],
        ],
    ],
    /*'assessmentResult' => [
    'title' => 'Penilaian Hasil EDS',
    'title_singular' => 'Penilaian Hasil EDS',
    ],
    'assessmentResultVerification' => [
    'title' => 'Verifikasi Hasil Penilaian',
    'title_singular' => 'Verifikasi Hasil Penilaian',
    ],*/
    /////////////////////////////////////////////////////////////////////////////////////////////////////
    'setting' => [
        'title' => 'Pengaturan',
        'title_singular' => 'Pengaturan',
    ],
    'banner' => [
        'title' => 'Banner',
        'title_singular' => 'Banner',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'slug' => 'Slug',
            'slug_helper' => '',
            'title' => 'Judul',
            'title_helper' => '',
            'image' => 'Gambar',
            'image_helper' => '',
            'created_at' => 'Dibuat pada',
            'created_at_helper' => '',
            'updated_at' => 'Diperbarui pada',
            'updated_at_helper' => '',
            'deleted_at' => 'Dihapus pada',
            'deleted_at_helper' => '',
        ],
    ],
    'province' => [
        'title' => 'Provinsi',
        'title_singular' => 'Provinsi',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'code' => 'Kode',
            'code_helper' => '',
            'name' => 'Nama Provinsi',
            'name_helper' => '',
            'created_at' => 'Dibuat pada',
            'created_at_helper' => '',
            'updated_at' => 'Diperbarui pada',
            'updated_at_helper' => '',
            'deleted_at' => 'Dihapus pada',
            'deleted_at_helper' => '',
        ],
    ],
    'city' => [
        'title' => 'Kabupaten/Kota',
        'title_singular' => 'Kabupaten/Kota',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'province' => 'Provinsi',
            'province_helper' => '',
            'code' => 'Kode',
            'code_helper' => '',
            'name' => 'Nama Kabupaten/Kota',
            'name_helper' => '',
            'created_at' => 'Dibuat pada',
            'created_at_helper' => '',
            'updated_at' => 'Diperbarui pada',
            'updated_at_helper' => '',
            'deleted_at' => 'Dihapus pada',
            'deleted_at_helper' => '',
        ],
    ],
    'curriculumCalendar' => [
        'title' => 'Kalender Pendidikan Terkait LH',
        'title_singular' => 'Kalender Pendidikan Terkait LH',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'slug' => 'Slug',
            'slug_helper' => '',
            'name' => 'Kalender Pendidikan Terkait LH',
            'name_helper' => '',
            'created_at' => 'Dibuat pada',
            'created_at_helper' => '',
            'updated_at' => 'Diperbarui pada',
            'updated_at_helper' => '',
            'deleted_at' => 'Dihapus pada',
            'deleted_at_helper' => '',
        ],
    ],
    'disasterThreat' => [
        'title' => 'Ancaman Bencana Sekolah',
        'title_singular' => 'Ancaman Bencana Sekolah',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'slug' => 'Slug',
            'slug_helper' => '',
            'name' => 'Ancaman Bencana Sekolah',
            'name_helper' => '',
            'created_at' => 'Dibuat pada',
            'created_at_helper' => '',
            'updated_at' => 'Diperbarui pada',
            'updated_at_helper' => '',
            'deleted_at' => 'Dihapus pada',
            'deleted_at_helper' => '',
        ],
    ],
    /////////////////////////////////////////////////////////////////////////////////////////////////////
    'userManagement' => [
        'title' => 'Manajemen Pengguna',
        'title_singular' => 'Manajemen Pengguna',
    ],
    'permission' => [
        'title' => 'Izin',
        'title_singular' => 'Izin',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'title' => 'Title',
            'title_helper' => '',
            'created_at' => 'Dibuat pada',
            'created_at_helper' => '',
            'updated_at' => 'Diperbarui pada',
            'updated_at_helper' => '',
            'deleted_at' => 'Dihapus pada',
            'deleted_at_helper' => '',
        ],
    ],
    'role' => [
        'title' => 'Peranan',
        'title_singular' => 'Peran',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'title' => 'Title',
            'title_helper' => '',
            'permissions' => 'Izin',
            'permissions_helper' => '',
            'created_at' => 'Dibuat pada',
            'created_at_helper' => '',
            'updated_at' => 'Diperbarui pada',
            'updated_at_helper' => '',
            'deleted_at' => 'Dihapus pada',
            'deleted_at_helper' => '',
        ],
    ],
    'user' => [
        'title' => 'Daftar Pengguna',
        'title_singular' => 'Pengguna',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'name' => 'Nama',
            'name_helper' => '',
            'email' => 'Email',
            'email_helper' => '',
            'email_verified_at' => 'Email diverifikasi pada',
            'email_verified_at_helper' => '',
            'password' => 'Password',
            'password_helper' => '',
            'roles' => 'Peran',
            'roles_helper' => '',
            'remember_token' => 'Remember Token',
            'remember_token_helper' => '',
            'created_at' => 'Dibuat pada',
            'created_at_helper' => '',
            'updated_at' => 'Diperbarui pada',
            'updated_at_helper' => '',
            'deleted_at' => 'Dihapus pada',
            'deleted_at_helper' => '',
            'approved' => 'Disetujui',
            'approved_helper' => '',
            'username' => 'Username',
            'username_helper' => '',
        ],
    ],
    'auditLog' => [
        'title' => 'Audit Logs',
        'title_singular' => 'Audit Log',
        'fields' => [
            'id' => 'ID',
            'id_helper' => ' ',
            'description' => 'Description',
            'description_helper' => ' ',
            'subject_id' => 'Subject ID',
            'subject_id_helper' => ' ',
            'subject_type' => 'Subject Type',
            'subject_type_helper' => ' ',
            'user_id' => 'User ID',
            'user_id_helper' => ' ',
            'properties' => 'Properties',
            'properties_helper' => ' ',
            'host' => 'Host',
            'host_helper' => ' ',
            'created_at' => 'Created at',
            'created_at_helper' => ' ',
            'updated_at' => 'Updated at',
            'updated_at_helper' => ' ',
        ],
    ],
    'environmentalIssue' => [
        'title' => 'Isu Lingkungan',
        'title_singular' => 'Isu Lingkungan',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'school' => 'Sekolah',
            'school_helper' => '',
            'year' => 'Tahun',
            'year_helper' => '',
            'potency' => 'Nama Potensi Isu',
            'potency_helper' => '',
            'date' => 'Tanggal Pencermatan',
            'date_helper' => '',
            'category' => 'Kategori Isu',
            'category_helper' => '',
            'problem' => 'Masalah Yang Timbul',
            'problem_helper' => '',
            'anticipation' => 'Kegiatan Antisipasinya',
            'anticipation_helper' => '',
            'compiler' => 'Penyusun',
            'compiler_helper' => '',
            'document' => 'Dokumen Terkait',
            'document_helper' => 'Upload (PDF, Foto)',
            'created_at' => 'Dibuat pada',
            'created_at_helper' => '',
            'updated_at' => 'Diperbarui pada',
            'updated_at_helper' => '',
            'deleted_at' => 'Dihapus pada',
            'deleted_at_helper' => '',
        ],
    ],
    'selfDevelopment' => [
        'title' => 'Pengembangan Diri',
        'title_singular' => 'Pengembangan Diri',
    ],
    'extracurricular' => [
        'title' => 'Ekstrakurikuler',
        'title_singular' => 'Ekstrakurikuler',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'school' => 'Sekolah',
            'school_helper' => '',
            'year' => 'Tahun',
            'year_helper' => '',
            'program' => 'Nama Program',
            'program_helper' => '',
            'tutor' => 'Guru Pembimbing',
            'tutor_helper' => '',
            'time' => 'Waktu Pelaksanaan',
            'time_helper' => '',
            'participants' => 'Peserta',
            'participants_helper' => '',
            'activity' => 'Bentuk Kegiatan',
            'activity_helper' => '',
            'target' => 'Target Karakter',
            'target_helper' => '',
            'letter' => 'Lampiran Terkait',
            'letter_helper' => 'Upload Pdf Modul & SK',
            'document' => 'Dokumentasi (Foto)',
            'document_helper' => 'Upload Jpg / Pdf',
            'created_at' => 'Dibuat pada',
            'created_at_helper' => '',
            'updated_at' => 'Diperbarui pada',
            'updated_at_helper' => '',
            'deleted_at' => 'Dihapus pada',
            'deleted_at_helper' => '',
        ],
    ],
    'habituation' => [
        'title' => 'Pembiasaan',
        'title_singular' => 'Pembiasaan Diri',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'school' => 'Sekolah',
            'school_helper' => '',
            'year' => 'Tahun',
            'year_helper' => '',
            'program' => 'Nama Program',
            'program_helper' => '',
            'category' => 'Kategori Pembiasaan',
            'category_helper' => '',
            'tutor' => 'Guru Pembimbing',
            'tutor_helper' => '',
            'time' => 'Waktu Pelaksanaan',
            'time_helper' => '',
            'participants' => 'Peserta',
            'participants_helper' => '',
            'activity' => 'Bentuk Kegiatan',
            'activity_helper' => '',
            'target' => 'Target Perilaku',
            'target_helper' => '',
            'letter' => 'Bukti Pendukung',
            'letter_helper' => 'Upload Jpg / Pdf',
            'document' => 'Dokumen (Foto)',
            'document_helper' => 'Upload Jpg / Pdf',
            'created_at' => 'Dibuat pada',
            'created_at_helper' => '',
            'updated_at' => 'Diperbarui pada',
            'updated_at_helper' => '',
            'deleted_at' => 'Dihapus pada',
            'deleted_at_helper' => '',
        ],
    ],
];
