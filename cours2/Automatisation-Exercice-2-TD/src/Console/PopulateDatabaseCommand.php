<?php

namespace App\Console;

use App\Models\Company;
use App\Models\Employee;
use App\Models\Office;
use Illuminate\Support\Facades\Schema;
use Slim\App;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PopulateDatabaseCommand extends Command
{
    private App $app;

    public function __construct(App $app)
    {
        $this->app = $app;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('db:populate');
        $this->setDescription('Populate database');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Populate database...');

        /** @var \Illuminate\Database\Capsule\Manager $db */
        $db = $this->app->getContainer()->get('db');

        $db->getConnection()->statement("SET FOREIGN_KEY_CHECKS=0");
        $db->getConnection()->statement("TRUNCATE `employees`");
        $db->getConnection()->statement("TRUNCATE `offices`");
        $db->getConnection()->statement("TRUNCATE `companies`");
        $db->getConnection()->statement("SET FOREIGN_KEY_CHECKS=1");

         $faker = \Faker\Factory::create('fr_FR');

    // 2 à 4 sociétés
        $companiesCount = rand(2, 4);

        for ($i = 0; $i < $companiesCount; $i++) {
            $company = \App\Models\Company::create([
            'name'    => $faker->company,
            'phone'   => $faker->phoneNumber,
            'email'   => $faker->companyEmail,
            'website' => $faker->url,
            ]);

            // 2 à 3 bureaux par société
            $offices = [];
            $officesCount = rand(2, 3);

            for ($j = 0; $j < $officesCount; $j++) {
                $office = \App\Models\Office::create([
                    'name'       => 'Bureau ' . $faker->city,
                    'address'    => $faker->streetAddress,
                    'city'       => $faker->city,
                    'zip_code'   => $faker->postcode,
                    'country'    => $faker->country,
                    'email'      => $faker->optional()->companyEmail,
                    'company_id' => $company->id,
                ]);

                $offices[] = $office;
            }

            // Définir le siège social
            $company->head_office_id = $offices[0]->id;
            $company->save();

            // Environ 10 employés par société
            $employeesCount = rand(8, 12);

            for ($k = 0; $k < $employeesCount; $k++) {
                $office = $faker->randomElement($offices);

                \App\Models\Employee::create([
                'first_name' => $faker->firstName,
                'last_name'  => $faker->lastName,
                'office_id'  => $office->id,
                'email'      => $faker->unique()->safeEmail,
                'job_title'  => $faker->jobTitle,
                ]);
            }
        }

        $output->writeln('Database populated successfully ✔');
        return Command::SUCCESS;
    }
}
