<?php





/**
 * create VCard
 * 
 */
class VCard {


    private $vcfId;
    private $firstname;
    private $lastname;
    private $emails = [];
    private $phones = [];
    private $addresss = [];
    private $filename;


    public function setFilename($filename) {
        $this->filename = $this->encodeFilename($filename);
    }

    public function getFilename(){
        return $this->filename;
    }

    public function setFirstname(string $firstname) {
        $this->firstname = $firstname;
    }

    public function getFirstname() {
        return $this->firstname;
    }

    public function setLastname(string $lastname) {
        $this->lastname = $lastname;
    }

    public function getFullName() {
        return $this->getFirstName().' '.$this->getLastname();
    }

    public function getLastname() {
        return $this->lastname;
    }

    public function addEmail($email) {
        $this->emails[] = $email;
    }

    public function getEmails() {
        return $this->emails;
    }

    public function addPhone($tel, $name) {
        $this->phones[] = ['name' => $name, 'tel' => $tel];
    }

    public function getPhones() {
        return $this->phones;
    }

    public function addAddress($name, $street, $city, $postalCode, $country) {
        $this->addresss[] = ['name' => $name, 'street' => $street, 'city' => $city, 'postalCode' => $postalCode, 'country' => $country];
    }

    public function getAddresss() {
        return $this->addresss;
    }

    public function encodeFilename($filename) {
        return $filename;
    }

    public function build() {
        $content  = "BEGIN:VCARD\r\n";
        $content .= "VERSION:3.0\r\n";
        $content .= "PRODID:-//Apple Inc.//iOS 5.0.1//EN\r\n";
        $content .= "N:".$this->getLastname().";".$this->getFirstName().";;;\r\n";
        $content .= "FN:".$this->getFullname()."\r\n";
        $content .= "ORG:EKA;\r\n";


        foreach($this->getEmails() as $email) {
            $content .= "EMAIL;type=INTERNET;type=HOME;type=pref:".$email."\r\n";
        }

        $i = 0;
        foreach($this->getPhones() as $phone) {
            $i++;
            ($i==1) ? $pref = ';type=pref' : $pref='';
            $content .= "item".$i.".TEL".$pref.":".$phone['tel']."\r\n";
            $content .= "item".$i.".X-ABLabel:".$phone['name']."\r\n";
        }

        $i = 0;
        foreach($this->getAddresss() as $address) {
            $i++;
            $content .= "item".$i.".ADR;type=".$address['name'].";type=pref:;;".$address['street'].";".$address['city'].";".$address['postalCode'].";".$address['country']."\r\n";
            $content .= "item".$i.".X-ABADR:fr\r\n";
        }

        $content .= "END:VCARD";

        return $content;
        
    }


    /**
     * Download a vcard or vcal file to the browser.
     */
    public function download()
    {
        // build vcazrd string
        $output = $this->build();

        foreach ($this->getHeaders(false) as $header) {
            header($header);
        }

        // echo the output and it will be a download
        echo $output;
    }

     /**
     * Get headers
     *
     * @param  bool $asAssociative
     * @return array
     */
    public function getHeaders($asAssociative)
    {
        $contentType = 'text/x-vcard' . '; charset=' . 'utf-8';
        $contentDisposition = 'attachment; filename=' . $this->getFilename() . '.vcf' ;
        $contentLength = mb_strlen($this->build(), '8bit');
        $connection = 'close';


        return [
            'Content-type: ' . 'text/x-vcard',
            'Content-Disposition: ' . $contentDisposition,
            'Content-Length: ' . $contentLength,
            'Connection: ' . $connection,
        ];
    }
}