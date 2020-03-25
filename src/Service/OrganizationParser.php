<?php


namespace App\Service;


use Symfony\Component\Yaml\Yaml;

class OrganizationParser
{
    const FILE_NAME = '/organization/organizations.yaml';
    protected $kernelRoot;

    public function __construct($kernelRoot)
    {
        $this->kernelRoot = $kernelRoot;
    }


    public function addOrganisation($organisation)
    {
        $value = Yaml::parse(file_get_contents($this->kernelRoot . '/..' . self::FILE_NAME));

        $value ['organizations'][] = $organisation;

        $yaml = Yaml::dump($value);

        file_put_contents($this->kernelRoot . '/..' . self::FILE_NAME, $yaml);

    }

    public function addOrganisationById($organisation, $id)
    {

        $value = Yaml::parse(file_get_contents($this->kernelRoot . '/..' . self::FILE_NAME));

        $value ['organizations'][$id] = $organisation;

        $yaml = Yaml::dump($value);

        file_put_contents($this->kernelRoot . '/..' . self::FILE_NAME, $yaml);
    }

    public function deleteOrganisationById($id)
    {

        $value = Yaml::parse(file_get_contents($this->kernelRoot . '/..' . self::FILE_NAME));

        unset($value['organizations'][$id]);

        $yaml = Yaml::dump($value);

        file_put_contents($this->kernelRoot . '/..' . self::FILE_NAME, $yaml);

    }


    public function loadYmlContent()
    {

        $value = Yaml::parse(file_get_contents($this->kernelRoot . '/..' . self::FILE_NAME));

        return $value;
    }
}
