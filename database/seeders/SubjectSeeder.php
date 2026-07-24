<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subjects = array(
            // ss1
            ['id'=> 1, 'class_id' => 4, 'subject_code' => "ENGSS1", 'subject_name' => "English Language",'created_at' => now()],
            ['id'=> 2, 'class_id' => 4,'subject_code' => "MATHSS1", 'subject_name' => "Mathematics",'created_at' => now()],
            ['id'=> 3, 'class_id' => 4,'subject_code' => "FMATHSSS1", 'subject_name' => "Further Maths",'created_at' => now()],
            ['id'=> 4, 'class_id' => 4,'subject_code' => "PHYSS1", 'subject_name' => "Physics",'created_at' => now()],
            ['id'=> 5, 'class_id' => 4,'subject_code' => "CHEMISTRYSS1", 'subject_name' => "Chemistry",'created_at' => now()],
            ['id'=> 6, 'class_id' => 4,'subject_code' => "BIOSS1", 'subject_name' => "Biology",'created_at' => now()],
            ['id'=> 7, 'class_id' => 4,'subject_code' => "ECONSS1", 'subject_name' => "Economic",'created_at' => now()],
            ['id'=> 8, 'class_id' => 4,'subject_code' => "GOVTSS1", 'subject_name' => "Government",'created_at' => now()],
            ['id'=> 9, 'class_id' => 4,'subject_code' => "GEOSS1", 'subject_name' => "Geography",'created_at' => now()],
            ['id'=> 10, 'class_id' => 4,'subject_code' => "LITSS1", 'subject_name' => "Literature-in–English",'created_at' => now()],
            ['id'=> 11, 'class_id' => 4,'subject_code' => "AGRICSS1", 'subject_name' => "Agricultural Science",'created_at' => now()],
            ['id'=> 12, 'class_id' => 4,'subject_code' => "ANIMALSS1", 'subject_name' => "Animal Husbandry",'created_at' => now()],
            ['id'=> 13, 'class_id' => 4,'subject_code' => "VATSS1", 'subject_name' => "Visual Art",'created_at' => now()],
            ['id'=> 14, 'class_id' => 4,'subject_code' => "CIVSS1", 'subject_name' => "Civil Education",'created_at' => now()],
            ['id'=> 15, 'class_id' => 4,'subject_code' => "YRSS1", 'subject_name' => "Yoruba Language",'created_at' => now()],
            ['id'=> 16, 'class_id' => 4,'subject_code' => "ACCSS1", 'subject_name' => "Accounts",'created_at' => now()],
            ['id'=> 17, 'class_id' => 4,'subject_code' => "BKEEPSS1", 'subject_name' => "Book Keeping",'created_at' => now()],
            ['id'=> 18, 'class_id' => 4,'subject_code' => "COMMSS1", 'subject_name' => "Commerce",'created_at' => now()],
            ['id'=> 19, 'class_id' => 4,'subject_code' => "MRKSS1", 'subject_name' => "Marketing",'created_at' => now()],
            ['id'=> 20, 'class_id' => 4,'subject_code' => "CRSSS1", 'subject_name' => "C.R.S",'created_at' => now()],
            ['id'=> 21, 'class_id' => 4,'subject_code' => "ISSS1", 'subject_name' => "I.S.S",'created_at' => now()],
            ['id'=> 22, 'class_id' => 4,'subject_code' => "CMPSS1", 'subject_name' => "Computer Studies",'created_at' => now()],
            //end ss1
            // start ss2
            ['id' => 23,'class_id' => 5,'subject_code' => "ENGSS2",'subject_name' => "English Language",'created_at' => now()],
            ['id' => 24,'class_id' => 5,'subject_code' => "MATHSS2",'subject_name' => "Mathematics",'created_at' => now()],
            ['id' => 25,'class_id' => 5,'subject_code' => "FMATHSSS2",'subject_name' => "Further Maths",'created_at' => now()],
            ['id' => 26,'class_id' => 5,'subject_code' => "PHYSS2",'subject_name' => "Physics",'created_at' => now()],
            ['id' => 27,'class_id' => 5,'subject_code' => "CHEMISTRYSS2",'subject_name' => "Chemistry",'created_at' => now()],
            ['id' => 28,'class_id' => 5,'subject_code' => "BIOSS2",'subject_name' => "Biology",'created_at' => now()],
            ['id' => 29,'class_id' => 5,'subject_code' => "ECONSS2",'subject_name' => "Economic",'created_at' => now()],
            ['id' => 30,'class_id' => 5,'subject_code' => "GOVTSS2",'subject_name' => "Government",'created_at' => now()],
            ['id' => 31,'class_id' => 5,'subject_code' => "GEOSS2",'subject_name' => "Geography",'created_at' => now()],
            ['id' => 32,'class_id' => 5,'subject_code' => "LITSS2",'subject_name' => "Literature- in –English",'created_at' => now()],
            ['id' => 33,'class_id' => 5,'subject_code' => "AGRICSS2",'subject_name' => "Agricultural Science",'created_at' => now()],
            ['id' => 34,'class_id' => 5,'subject_code' => "ANIMALSS2",'subject_name' => "Animal Husbandry",'created_at' => now()],
            ['id' => 35,'class_id' => 5,'subject_code' => "VATSS2",'subject_name' => "Visual Art",'created_at' => now()],
            ['id' => 36,'class_id' => 5,'subject_code' => "CIVSS2",'subject_name' => "Civil Education",'created_at' => now()],
            ['id' => 37,'class_id' => 5,'subject_code' => "YRSS2",'subject_name' => "Yoruba Language",'created_at' => now()],
            ['id' => 38,'class_id' => 5,'subject_code' => "ACCSS2",'subject_name' => "Accounts",'created_at' => now()],
            ['id' => 39,'class_id' => 5,'subject_code' => "BKEEPSS2",'subject_name' => "Book Keeping",'created_at' => now()],
            ['id' => 40,'class_id' => 5,'subject_code' => "COMMSS2",'subject_name' => "Commerce",'created_at' => now()],
            ['id' => 41,'class_id' => 5,'subject_code' => "MRKSS2",'subject_name' => "Marketing",'created_at' => now()],
            ['id' => 42,'class_id' => 5,'subject_code' => "CRSSS2",'subject_name' => "C.R.S",'created_at' => now()],
            ['id' => 43,'class_id' => 5,'subject_code' => "ISSS2",'subject_name' => "I.S.S",'created_at' => now()],
            ['id' => 44,'class_id' => 5,'subject_code' => "CMPSS2",'subject_name' => "Computer Studies",'created_at' => now()],
            // end ss2
            // ss3
            ['id' => 45,'class_id' => 6,'subject_code' => "ENGSS3",'subject_name' => "English Language",'created_at' => now()],
            ['id' => 46,'class_id' => 6,'subject_code' => "MATHSS3",'subject_name' => "Mathematics",'created_at' => now()],
            ['id' => 47,'class_id' => 6,'subject_code' => "FMATHSSS3",'subject_name' => "Further Maths",'created_at' => now()],
            ['id' => 48,'class_id' => 6,'subject_code' => "PHYSS3",'subject_name' => "Physics",'created_at' => now()],
            ['id' => 49,'class_id' => 6,'subject_code' => "CHEMISTRYSS3",'subject_name' => "Chemistry",'created_at' => now()],
            ['id' => 50,'class_id' => 6,'subject_code' => "BIOSS3",'subject_name' => "Biology",'created_at' => now()],
            ['id' => 51,'class_id' => 6,'subject_code' => "ECONSS3",'subject_name' => "Economic",'created_at' => now()],
            ['id' => 52,'class_id' => 6,'subject_code' => "GOVTSS3",'subject_name' => "Government",'created_at' => now()],
            ['id' => 53,'class_id' => 6,'subject_code' => "GEOSS3",'subject_name' => "Geography",'created_at' => now()],
            ['id' => 54,'class_id' => 6,'subject_code' => "LITSS3",'subject_name' => "Literature- in –English",'created_at' => now()],
            ['id' => 55,'class_id' => 6,'subject_code' => "AGRICSS3",'subject_name' => "Agricultural Science",'created_at' => now()],
            ['id' => 56,'class_id' => 6,'subject_code' => "ANIMALSS3",'subject_name' => "Animal Husbandry",'created_at' => now()],
            ['id' => 57,'class_id' => 6,'subject_code' => "VATSS3",'subject_name' => "Visual Art",'created_at' => now()],
            ['id' => 58,'class_id' => 6,'subject_code' => "CIVSS3",'subject_name' => "Civil Education",'created_at' => now()],
            ['id' => 59,'class_id' => 6,'subject_code' => "YRSS3",'subject_name' => "Yoruba Language",'created_at' => now()],
            ['id' => 60,'class_id' => 6,'subject_code' => "ACCSS3",'subject_name' => "Accounts",'created_at' => now()],
            ['id' => 61,'class_id' => 6,'subject_code' => "BKEEPSS3",'subject_name' => "Book Keeping",'created_at' => now()],
            ['id' => 62,'class_id' => 6,'subject_code' => "COMMSS3",'subject_name' => "Commerce",'created_at' => now()],
            ['id' => 63,'class_id' => 6,'subject_code' => "MRKSS3",'subject_name' => "Marketing",'created_at' => now()],
            ['id' => 64,'class_id' => 6,'subject_code' => "CRSSS3",'subject_name' => "C.R.S",'created_at' => now()],
            ['id' => 65,'class_id' => 6,'subject_code' => "ISSS3",'subject_name' => "I.S.S",'created_at' => now()],
            ['id' => 66,'class_id' => 6,'subject_code' => "CMPSS3",'subject_name' => "Computer Studies",'created_at' => now()],
            // end ss3
            //jss1
            ['id'=> 67,'class_id' => 1, 'subject_code' => "ENGJSS1", 'subject_name' => "English Language",'created_at' => now()],
            ['id'=> 68, 'class_id' => 1,'subject_code' => "MATHJSS1", 'subject_name' => "Mathematics",'created_at' => now()],
            ['id'=> 69, 'class_id' => 1,'subject_code' => "CIVJSS1", 'subject_name' => "Civil Education",'created_at' => now()],
            ['id'=> 70, 'class_id' => 1,'subject_code' => "BUSJSS1", 'subject_name' => "BUSINESS STUDIES",'created_at' => now()],
            ['id'=> 71, 'class_id' => 1,'subject_code' => "CMPJSS1", 'subject_name' => "Computer Studies",'created_at' => now()],
            // end jss1
            // startss2
            ['id' => 72,'class_id' => 2,'subject_code' => "ENGJSS2",'subject_name' => "English Language",'created_at' => now()],
            ['id' => 73,'class_id' => 2,'subject_code' => "MATHJSS2",'subject_name' => "Mathematics",'created_at' => now()],
            ['id' => 74,'class_id' => 2,'subject_code' => "CIVJSS2",'subject_name' => "Civil Education",'created_at' => now()],
            ['id' => 75,'class_id' => 2,'subject_code' => "BUSJSS2",'subject_name' => "BUSINESS STUDIES",'created_at' => now()],
            ['id' => 76,'class_id' => 2,'subject_code' => "CMPJSS2",'subject_name' => "Computer Studies",'created_at' => now()],
            // end ss2
            // ss3
            ['id' => 77,'class_id' => 3,'subject_code' => "ISSS3",'subject_name' => "I.S.S",'created_at' => now()],
            ['id' => 78,'class_id' => 3,'subject_code' => "CMPSS3",'subject_name' => "Computer Studies",'created_at' => now()],
            ['id' => 79,'class_id' => 3,'subject_code' => "ENGJSS3",'subject_name' => "English Language",'created_at' => now()],
            ['id' => 80,'class_id' => 3,'subject_code' => "MATHJSS3",'subject_name' => "Mathematics",'created_at' => now()],
            ['id' => 81,'class_id' => 3,'subject_code' => "CIVJSS3",'subject_name' => "Civil Education",'created_at' => now()],
            ['id' => 82,'class_id' => 3,'subject_code' => "BUSJSS3",'subject_name' => "BUSINESS STUDIES",'created_at' => now()],
            ['id' => 83,'class_id' => 3,'subject_code' => "CMPJSS3",'subject_name' => "Computer Studies",'created_at' => now()],
            // end ss3


        );

        DB::table('subjects')->insert($subjects);
    }
}
