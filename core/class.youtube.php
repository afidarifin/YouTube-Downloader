<?php
/**
 * @Package YouTube Download by Afid Arifin
 * @Version v1.0
 * @Email   afidbara@gmail.com
 */
ini_set('display_errors', 0);

try {
  class YouTube {
    public function url($url) {
      parse_str(parse_url($url, PHP_URL_QUERY), $vars);
      return $vars['v'];
    }
    
    public function details($id) {
      parse_str(file_get_contents('https://youtube.com/get_video_info?video_id='.$id), $info);
      $json       = json_decode($info['player_response']);
      $formats    = $json->streamingData->formats;
      $adaptive   = $json->streamingData->adaptiveFormats;
      $isPlayable = $json->playabilityStatus->status;
      $result     = [];

      if(strtolower($isPlayable) != 'ok') {
        echo '<b>Ooops!</b> Your video cannot be processed!';
        exit;
      }

      if(!empty($info) && $info['status'] == 'ok' && strtolower($isPlayable) == 'ok') {
        $i = 0;
        foreach($adaptive as $stream) {
          $streamUrl = $stream->url;
          $type = explode(';', $stream->mimeType);

          $quality = '';
          if(!empty($stream->qualityLabel)) {
            $quality = $stream->qualityLabel;
          }

          $video[$i]['link']    = $streamUrl;
          $video[$i]['type']    = $type[0];
          $video[$i]['quality'] = $quality;

          $i++;
        }

        $j = 0;
        foreach($formats as $stream) {
          $streamUrl = $stream->url;
          $type = explode(';', $stream->mimeType);

          $quality = '';
          if(!empty($stream->qualityLabel)) {
            $quality = $stream->qualityLabel;
          }

          $_video[$i]['link']    = $streamUrl;
          $_video[$i]['type']    = $type[0];
          $_video[$i]['quality'] = $quality;

          $j++;
        }

        $result['videos'] = [
          'info'             => $info,
          'adapativeFormats' => $video,
          'formats'          => $formats,
        ];

        return $result;
      } else {
        return;
      }
    }
  }
} catch(Exception $e) {
  echo '<b>Warning!</b> '.$e->getMessage().'; (<b>Trace</b>: '.$e->getCode().')';
}
?>