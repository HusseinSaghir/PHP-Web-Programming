<?php 

class Directories {

private $basePath;
private $message = '';
private $success = false;
private $filePath = '';

public function __construct() {

//points us to the directories folder
$this->basePath = __DIR__ . '/../directories/';
}


//Creates new directories folder 
public function createDirectory(string $dirName, string $content): void {

//Parameters for folder creation
if(!preg_match('/^[A-Za-z0-9]+$/', $dirName)) {
        $this->message = 'Error: Folder name must contain letters or numbers only.';
        $this->success = false;
        return;
    }

$newDirPath = $this->basePath .$dirName;

if(is_dir($newDirPath)) {
    $this->message = 'A directory already exists with that name';
    $this->success = false;
    return;
}

//Attempts to make new directory
if(!mkdir($newDirPath, 0777, true)) {
    $this->message = 'Error: The directory could not be created because you lack proper permissions.';
    $this->success = false;
    return;
}

//Attempts to create new readme.txt in the new directory
$readmePath = $newDirPath . '/readme.txt';
if(file_put_contents($readmePath, $content) === false) {
    $this->message = 'Error: The file could not be created';

    $this -> success = false;
    return;
}

//Passed
$this -> success = true;
$this->filePath = 'directories/' . $dirName . '/readme.txt';
$this-> message = 'Directory and file created successfully';
}


//Returns true
public function isSuccess(): bool {
    return $this -> success;
}

//Returns the status message
public function getMessage(): string {
    return $this->message;
}

//Returns the relative path
public function getFilePath(): string {
    return $this->filePath;
}
}