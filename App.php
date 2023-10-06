<?php

require_once "./Constants.php";
require_once "./Exceptions.php";

class App
{
    private string $uri;
    private array $uri_array;
    private string $filename;

    public function __construct() {
        $this->uri = $_SERVER["REQUEST_URI"];
        $this->setup();
        $this->resetSession();
        $this->setSession(SESSION_PATH, $this->filename);
    }

    public function init() {
        try {
            printf("uri -> $this->uri");
            $this->setPage();
        } catch (Throwable $th) {
            throw $th;
        }
    }

    private function setup() {
        $this->splitPath();
        $this->extractFilename();
    }

    private function extractFilename() {
        $this->filename = end($this->uri_array);
    }

    private function splitPath() {
        $this->uri_array = explode("/",$this->uri);
        array_shift($this->uri_array);
    }

    private function createFilepath(): string {
        $file = __DIR__ . "/views/" . $this->filename . EXT_FILE;
        if(!file_exists($file)) {
            throw new UnknownFileException();
        }
        return $file;
    }

    private function setPage() {
        if(count($this->uri_array) < 1) {
            throw new WrongPathException();
        }
        include $this->createFilepath();
    }

    private function setHeader(int $secondTimerRefresh) {
        header("refresh: $secondTimerRefresh");
    }

    private function setSession(string $key, string|int|bool $value) {
        $_SESSION[$key] = $value;
    }

    private function resetSession() {
        $_SESSION = NULL;
    }
}