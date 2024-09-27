<?php
namespace System\Drivers\Cache;

class FilesCache extends Cache {

    protected $cacheDir;

    /**
     * Kết nối đến hệ thống lưu trữ file
     */
    protected function connect() {
        $this->cacheDir = ROOT_PATH . '/writeable/Cache/';
        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0755, true);
        }
    }

    public function set($key, $value, $ttl = 3600) {
        $cacheFile = $this->cacheDir . md5($key);
        $data = [
            'value' => serialize($value),
            'expiry' => time() + $ttl
        ];
        return file_put_contents($cacheFile, json_encode($data)) !== false;
    }

    public function get($key) {
        $cacheFile = $this->cacheDir . md5($key);
        if (file_exists($cacheFile)) {
            $data = json_decode(file_get_contents($cacheFile), true);
            if ($data['expiry'] > time()) {
                return unserialize($data['value']);
            }
            $this->delete($key);
        }
        return null;
    }

    public function delete($key) {
        $cacheFile = $this->cacheDir . md5($key);
        return file_exists($cacheFile) ? unlink($cacheFile) : false;
    }

    public function has($key) {
        $cacheFile = $this->cacheDir . md5($key);
        return file_exists($cacheFile);
    }

    public function clear() {
        $files = glob($this->cacheDir . '*');
        foreach ($files as $file) {
            unlink($file);
        }
        return true;
    }
}
