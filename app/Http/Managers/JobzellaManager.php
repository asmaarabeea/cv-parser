<?php namespace App\Http\Managers;


class JobzellaManager
{
    public function processCvInfo($info)
    {
        $this->reformatCvInfo($info);
    }

    public function reformatCvInfo($info)
    {

        $data['name']           = $info['contact_info']['full_name'];
        $data['date_of_birth']  = $info['contact_info']['birth_date'];
        $data['marital_status'] = $info['contact_info']['marital_status'];
        $data['nationality']    = $info['contact_info']['nationality'];
        $data['sex']            = $info['contact_info']['sex'];
        $data['email']          = $info['contact_info']['email'];
        $data['summary']        = $info['summury'];
        $data['objective']      = $info['objective'];
        $data['job_title']      = $this->getValue('TITLE');
        $data['skills']         = array_column($info['skills'], 'name');


        //Experiences
        $data['experiences'] = [];
        $experiences         = $this->getExperiencesArr('COMPETENCY');
        $locations           = array_pad($this->getValuesArr('MUNICIPALITY'), count($experiences), '');
        $companies_names     = array_pad($this->getValuesArr('EMPLOYERORGNAME'), count($experiences), '');
        $startYears          = array_pad($this->getStartYearsArr('STARTDATE'), count($experiences), NULL);
        $endYears            = array_pad($this->getEndYearsArr('ENDDATE'), count($experiences), NULL);
        $descriptions        = array_pad($this->getValuesArr('DESCRIPTION'), count($experiences), NULL);

        foreach ($experiences as $key => $experience) {
            array_push($data['experiences'], [
                'title'        => $experience,
                'location'     => $locations[$key],
                'company_name' => $companies_names[$key],
                'period_from'  => $startYears[$key],
                'period_to'    => $endYears[$key],
                'description'  => $descriptions[$key],
            ]);
        }
        //End of experiences

        $data['degrees']       = $this->getDegreesArr('COMPETENCY');
        $data['organizations'] = $this->getValuesArr('EMPLOYERORGNAME');
        $data['languages']     = $this->getValuesArr('LANGUAGECODE');

        $data['school'] = [
            'name'        => $this->getValue('SCHOOLNAME'),
            'degree'      => $this->getValue('DEGREENAME'),
            'field_study' => $this->getValue('MAJOR'),
            'year'        => $this->getValue('YEAR'),
        ];

        $data['address'] = [
            'streetName'      => $this->getValue('STREETNAME'),
            'buildingNumber'  => $this->getValue('BUILDINGNUMBER'),
            'addressLine'     => $this->getValue('ADDRESSLINE'),
            'region'          => $this->getValue('REGION'),
            'postalCode'      => $this->getValue('POSTALCODE'),
            'countryCode'     => $this->getValue('COUNTRYCODE'),
            'formattedNumber' => $this->getValuesArr('FORMATTEDNUMBER'),
        ];
        return $data;
    }
}