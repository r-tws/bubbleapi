<?php
$dir = "a/";
if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $src_data = file_get_contents($_FILES['image']['tmp_name']);
    $src = imagecreatefromstring($src_data);
    
    if ($src) {
        $w = imagesx($src);
        $h = imagesy($src);
        
        $bubble_raw = imagecreatefrompng("bubble.png");
        $bw = imagesx($bubble_raw);
        $bh_orig = imagesy($bubble_raw);
        
        $ratio = $w / $bw;
        $bh = (int)($bh_orig * $ratio);

        $bubble_resized = imagecreatetruecolor($w, $bh);
        imagealphablending($bubble_resized, false);
        imagesavealpha($bubble_resized, true);
        imagecopyresampled($bubble_resized, $bubble_raw, 0, 0, 0, 0, $w, $bh, $bw, $bh_orig);

        $canvas = imagecreatetruecolor($w, $h);
        imagealphablending($canvas, false);
        imagesavealpha($canvas, true);
        
        imagecopy($canvas, $src, 0, 0, 0, 0, $w, $h);

        imagealphablending($canvas, true);
        imagecopy($canvas, $bubble_resized, 0, 0, 0, 0, $w, $bh);
        
        $name = "u_" . uniqid() . ".gif";
        $path = $dir . $name;
        
        imagegif($canvas, $path);
        
        imagedestroy($src);
        imagedestroy($bubble_raw);
        imagedestroy($bubble_resized);
        imagedestroy($canvas);
        
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
        $url = $protocol . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/" . $path;
        
        header('Content-Type: application/json');
        echo json_encode(["status" => "success", "url" => $url]);
        exit;
    }
}

http_response_code(400);
echo json_encode(["status" => "error", "message" => "upload failed"]);
