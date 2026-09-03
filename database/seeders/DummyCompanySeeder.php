<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;
use App\Models\CompanyLocation;
use App\Models\CompanyRepresentative;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
use App\Models\Kbli;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class DummyCompanySeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        // Prepare locations
        $provinces = Province::limit(10)->get();
        if ($provinces->isEmpty()) {
            $this->command->error('No provinces found. Run db:seed --class=LocationSeeder first.');
            return;
        }
        $kblis = Kbli::all();
        if ($kblis->isEmpty()) {
            $this->command->error('No KBLIs found. Run db:seed --class=KbliSeeder first.');
            return;
        }

        $types = ['orang-perseorangan', 'badan-usaha', 'kantor-perwakilan', 'badan-usaha-luar-negeri'];

        for ($i = 1; $i <= 20; $i++) {
            $uniq = uniqid();
            // 1. Create User
            $user = User::create([
                'name' => $faker->name,
                'email' => "dummycompany_{$uniq}@example.com",
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
                'role' => 'user'
            ]);

            // 2. Determine type and details
            $pelakuUsaha = $types[array_rand($types)];
            
            $detail = null;
            $skala = 'mikro';
            
            $umkm_scales = ['mikro', 'kecil', 'menengah'];

            if ($pelakuUsaha === 'badan-usaha') {
                $badanUsahaTypes = ['PT', 'CV', 'Firma', 'Koperasi', 'Yayasan'];
                $detail = $badanUsahaTypes[array_rand($badanUsahaTypes)];
                $skala = (rand(0, 1) == 1) ? 'besar' : $umkm_scales[array_rand($umkm_scales)];
            } elseif ($pelakuUsaha === 'kantor-perwakilan') {
                $kpTypes = ['KPPA', 'KP3A', 'BUJKA'];
                $detail = $kpTypes[array_rand($kpTypes)];
                $skala = 'besar'; // Must be Usaha Besar
            } elseif ($pelakuUsaha === 'badan-usaha-luar-negeri') {
                $detail = 'Pemberi Waralaba';
                $skala = 'besar';
            } elseif ($pelakuUsaha === 'orang-perseorangan') {
                $skala = $umkm_scales[array_rand($umkm_scales)];
            }

            // 3. Create Company
            $company = Company::create([
                'user_id' => $user->id,
                'name' => $pelakuUsaha === 'orang-perseorangan' ? $user->name : $faker->company,
                'pelaku_usaha_type' => $pelakuUsaha,
                'pelaku_usaha_detail' => $detail,
                'perseorangan_nik' => $pelakuUsaha === 'orang-perseorangan' ? $faker->numerify('################') : null,
                'nib_number' => $faker->numerify('#############'),
                'nib_link' => 'https://example.com/nib.pdf',
                'npwp_number' => $faker->numerify('##.###.###.#-###.###'),
                'npwp_link' => 'https://example.com/npwp.pdf',
                'is_pkp' => rand(0, 1) ? 'true' : 'false',
                'pkp_link' => 'https://example.com/pkp.pdf',
                'is_npwp_same_as_nik' => 'false',
                'is_usaha_same_as_office' => 'true',
                'skala_usaha' => $skala,
                'status' => 'pending' // So they show up in dashboard!
            ]);

            // 4. Attach random KBLIs
            $companyKblis = $kblis->random(rand(1, 3))->pluck('code')->toArray();
            $company->kblis()->sync($companyKblis);

            // 5. Representative
            $kewarganegaraan = rand(0, 1) ? 'WNI' : 'WNA';
            CompanyRepresentative::create([
                'company_id' => $company->id,
                'name' => $faker->name,
                'position' => $pelakuUsaha === 'orang-perseorangan' ? 'Pemilik' : 'Direktur',
                'citizenship_type' => $kewarganegaraan,
                'identity_type' => $kewarganegaraan === 'WNI' ? 'NIK' : 'PASPOR',
                'identity_number' => $faker->numerify('################'),
                'nationality' => $kewarganegaraan === 'WNI' ? null : 'Singapore',
            ]);

            // 6. Locations
            $prov = $provinces->random();
            $reg = Regency::where('province_id', $prov->id)->inRandomOrder()->first();
            $dist = $reg ? District::where('regency_id', $reg->id)->inRandomOrder()->first() : null;
            $vill = $dist ? Village::where('district_id', $dist->id)->inRandomOrder()->first() : null;

            CompanyLocation::create([
                'company_id' => $company->id,
                'type' => 'KANTOR_UTAMA',
                'province_id' => $prov->id,
                'regency_id' => $reg ? $reg->id : null,
                'district_id' => $dist ? $dist->id : null,
                'village_id' => $vill ? $vill->id : null,
                'address' => $faker->address,
                'latitude' => $faker->latitude(-9, 5),
                'longitude' => $faker->longitude(95, 140),
            ]);

            CompanyLocation::create([
                'company_id' => $company->id,
                'type' => 'LOKASI_USAHA',
                'province_id' => $prov->id,
                'regency_id' => $reg ? $reg->id : null,
                'district_id' => $dist ? $dist->id : null,
                'village_id' => $vill ? $vill->id : null,
                'address' => $faker->address,
                'latitude' => $faker->latitude(-9, 5),
                'longitude' => $faker->longitude(95, 140),
            ]);
        }
        
        $this->command->info('20 dummy companies successfully created!');
    }
}
