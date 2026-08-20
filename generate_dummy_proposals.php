<?php
use App\Models\Project;
use App\Models\Company;
use App\Models\Proposal;

// Get all published projects
$projects = Project::where('status', 'published')->get();
$companies = Company::all();

$faker = \Faker\Factory::create('id_ID');

$statuses = ['pending', 'reviewed', 'negotiating', 'accepted', 'rejected'];

$createdCount = 0;

foreach ($projects as $project) {
    $ownerCompany = $project->company;
    
    if (!$ownerCompany) continue;
    
    // Decide who can send: 
    if (in_array(strtolower($ownerCompany->skala_usaha ?? ''), ['menengah', 'besar'])) {
        // Owner is UB, find UMKM
        $potentialSenders = $companies->filter(function($c) use ($ownerCompany) {
            return $c->id !== $ownerCompany->id && in_array(strtolower($c->skala_usaha ?? ''), ['mikro', 'kecil']);
        });
    } else {
        // Owner is UMKM, find UB
        $potentialSenders = $companies->filter(function($c) use ($ownerCompany) {
            return $c->id !== $ownerCompany->id && in_array(strtolower($c->skala_usaha ?? ''), ['menengah', 'besar']);
        });
    }
    
    // Pick 1 to 3 random senders
    $sendersToPick = min(rand(1, 3), $potentialSenders->count());
    
    if ($sendersToPick > 0) {
        $selectedSenders = $potentialSenders->random($sendersToPick);
        
        foreach ($selectedSenders as $sender) {
            // Check if already exists
            $exists = Proposal::where('project_id', $project->id)
                              ->where('company_id', $sender->id)
                              ->exists();
                              
            if (!$exists) {
                Proposal::create([
                    'project_id' => $project->id,
                    'company_id' => $sender->id,
                    'cover_letter' => "Halo,\n\nKami sangat tertarik dengan proyek/penawaran ini: {$project->title}. Kami memiliki pengalaman yang relevan dan kapasitas untuk memenuhi kebutuhan Anda. Berikut adalah rincian penawaran kami:\n\n" . $faker->paragraph(3) . "\n\nTerima kasih.",
                    'estimated_value' => $faker->randomElement([null, rand(5, 50) * 1000000]),
                    'status' => $faker->randomElement($statuses),
                    'pinned_portfolios' => [],
                    'attachment' => null
                ]);
                $createdCount++;
            }
        }
    }
}

echo "Berhasil membuat $createdCount proposal/ketertarikan dummy!\n";
