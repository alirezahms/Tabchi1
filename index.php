<?php // c89
/*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
error_reporting(E_ALL);
ignore_user_abort(true);
ini_set('memory_limit', '1024M');
ini_set('display_errors', '1');
ini_set('max_execution_time', '0');
ini_set('display_startup_errors', '1');
date_default_timezone_set('Asia/Tehran');
/*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
use Amp\Promise;
use danog\Loop\Generic\GenericLoop;
use danog\MadelineProto\API;
use danog\MadelineProto\EventHandler;
use danog\MadelineProto\Logger as MPLogger;
use danog\MadelineProto\RPCErrorException;
use danog\MadelineProto\Settings;
use danog\MadelineProto\Settings\AppInfo;
use danog\MadelineProto\Settings\Database\Mysql as MPSql;
use danog\MadelineProto\Settings\Logger;
use danog\MadelineProto\Settings\Peer;
use danog\MadelineProto\Settings\Serialization;
use function Amp\File\{exists, get, open, put, unlink};
/*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
!is_dir     ('Data') ? mkdir('Data')                  : null;
!is_dir     ('Data/Baner') ? mkdir('Data/Baner')      : null;
!is_dir     ('Data/media') ? mkdir('Data/media')      : null;
!is_dir     ('Data/AutoFor') ? mkdir('Data/AutoFor')  : null;
!is_dir     ('Data/media/Gp') ? mkdir('Data/media/Gp'): null;
!is_dir     ('Data/media/Pv') ? mkdir('Data/media/Pv'): null;
!file_exists('Data/user.txt') ? touch('Data/user.txt'): null;
/*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
function progress($empty, $fill, $min, $max = 100, $length = 10, $join = '')
{
    $pf = round($min / $max * $length);
    $pe = $length - $pf;
    $pe = $pe == 0 ? '' : str_repeat($empty, $pe);
    $pf = $pf == 0 ? '' : str_repeat($fill, $pf);
    return $pf . $join . $pe . " " . round(($min / $max * 100), 2) . " " . '%';
}
/*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
function bytesShortener($bytes, int $round = 0): string
{
    $units = [
        '????????',
        '????????????????',
        '??????????????',
        '????????????????',
        '??????????????',
        '????????????????'
    ];
    $index = 0;
    while ($bytes > 1024) {
        $bytes /= 1024;
        if (++$index === 8) {
            break;
        }

    }
    if ($round !== 0) {
        $bytes = round($bytes, $round);
    }
    return "$bytes {$units[$index]}";
}
/*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
function SaveData($data, $filename)
{
    file_put_contents($filename, json_encode($data, 448));
}
/*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
if (!file_exists("Data/data.json")) {
    $dataE['data'] = [
        'step'         => 0,
        'Join'         => 0,
        'SaveLink'     => 0,
        'JoinSave'     => 0,
        'CheckLink'    => 0,
        'ChatPV'       => 0,
        'ChatGP'       => 0,
        'Hoshgp'       => 0,
        'Hoshpv'       => 0,
        'SendMediaGp'  => 0,
        'SendMediaPv'  => 0,
        'AntiLogin'    => 0,
        'Contacts'     => 0,
        'ContactsPV'   => 0,
        'ForChannel'   => 0,
        'AutoFor'      => 0,
        'AutoSend'     => 0,
        'AutoBanerGp'  => 0,
        'AutoBanerPv'  => 0,
        'AutoLeaveBan' => 0,
        'Clicker'      => 0,
        'EmojiCode'    => 1,
        'MaxGroup'     => 400,
        'MinGroup'     => 1000,
        'Bot'          => 1,
    ];
    $dataE['MediaGp'] = [];
    $dataE['MediaPv'] = [];
    $dataE['Admins']  = [];
    $dataE['ChatPV']  = [];
    $dataE['ChatGP']  = [];
    SaveData($dataE, 'Data/data.json');
}
/*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
if (!file_exists('Data/link.json')) {
    $Link['Link'] = [
        'Link'     => [],
        'True'     => 0,
        'False'    => 0,
        'Time'     => 0,
        'Limit'    => 0,
        'LastTime' => 0,
    ];
    SaveData($Link, 'Data/link.json');
}
/*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
if (!file_exists('Data/AutoFor/data.json')) {
    file_put_contents('Data/AutoFor/data.json', '');
}
/*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
if (is_file(__DIR__ . '/../vendor/autoload.php')) {
    require __DIR__ . '/../vendor/autoload.php';
}
else {
    if (!is_file('madeline.php')) {
        copy('https://phar.madelineproto.xyz/madeline.php', 'madeline.php');
    }
    require 'madeline.php';
}
/*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
/*if (PHP_SAPI === 'cli' || PHP_SAPI === 'phpdbg') {
  sleep(5);
}*/
/*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
include 'Config.php';
include 'sdf.php';

/*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
class SharpPlus extends EventHandler
{
    const Report = 'pv_Cx';

    /**
     * @return string[]
     */
    public function getReportPeers(): array
    {
        return [self::Report];
    }

    /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */

    /**
     * @var bool
     */
    private static bool $working = false;

    /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */

    /**
     * @return bool
     */
    public function isWorking(): bool
    {
        return self:: $working;
    }

    /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
    private function exec(Closure $fn): Generator
    {
        self::$working = true;

        $result = $fn->call($this);
        if ($result instanceof Promise) {
            yield $result;
        } elseif ($result instanceof Generator) {
            yield from $result;
        }

        self::$working = false;
    }

    /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */

    /**
     * @return float|Generator|int
     */
    public function JoinSave()
    {
        if (file_exists('Data/data.json') && file_exists('Data/link.json')) {
            $dataE = json_decode((yield get('Data/data.json')), true);
            $Link  = json_decode((yield get('Data/link.json')), true);
            if ($dataE['data']['JoinSave'] == 1 && !empty($Link['Link']['Link'])) {
                $AllLinks = $Link['Link']['Link'];
                $rand     = array_rand($AllLinks);
                $join     = $AllLinks[$rand];
                try {
                    $check = yield $this->messages->checkChatInvite([
                        'hash' => $join
                    ]);
                    if ((!empty($check['participants_count']) ? $check['participants_count'] : (yield $this->getFullInfo('https://t.me/joinchat/' . $join)['full']['participants_count'])) <= ($dataE['data']['MinGroup'] ?? 400)) {
                        throw new Exception('INVITE_HASH_EXPIRED');
                    } elseif ($dataE['data']['CheckLink'] == 0 || ($dataE['data']['CheckLink'] == 1 && !($check['broadcast'] ?? $check['chat']['broadcast'] ?? true))) {
                        yield $this->messages->importChatInvite([
                            'hash' => $join
                        ]);
                        $Link['Link']['True'] += 1;
                        unset($Link['Link']['Link'][$rand]);
                        yield put('Data/link.json', json_encode($Link, 448));
                    }
                } catch (Throwable $e) {
                    if (strpos($e->getMessage(), 'FLOOD_WAIT_') !== false) {
                        $time            = str_replace('FLOOD_WAIT_', '', $e->getMessage());
                        $Link['Link']['Limit'] = $time;
                        yield put('Data/link.json', json_encode($Link, 448));
                    } elseif (strpos($e->getMessage(), 'INVITE_HASH_EXPIRED') !== false) {
                        $Link['Link']['False'] += 1;
                        unset($Link['Link']['Link'][$rand]);
                        yield put('Data/link.json', json_encode($Link, 448));
                    } elseif (strpos($e->getMessage(), 'INVITE_HASH_INVALID') !== false) {
                        $Link['Link']['False'] += 1;
                        unset($Link['Link']['Link'][$rand]);
                        yield put('Data/link.json', json_encode($Link, 448));
                    } elseif (strpos($e->getMessage(), 'CHANNELS_TOO_MUCH') !== false) {
                        $dataE['data']['JoinSave'] = 0;
                        yield put('Data/data.json', json_encode($dataE, 448));
                    } elseif (strpos($e->getMessage(), 'USER_ALREADY_PARTICIPANT') !== false) {
                    }
                }
            }
            $Link['Link']['Time']     = time() + 4 * 60000;
            $Link['Link']['LastTime'] = time();
            yield put('Data/link.json', json_encode($Link, 448));
        }
        return 4 * 60000;
    }

    /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */

    /**
     * @return Generator|int
     */
    public function Autoffor()
    {
        if (file_exists('Data/AutoFor/data.json') && file_exists('Data/data.json')) {
            $Autofor = json_decode((yield get('Data/AutoFor/data.json')), true);
            $dataE   = json_decode((yield get('Data/data.json')), true);
            yield from $this->exec(function () use ($Autofor, $dataE) {
                if ($dataE['data']['AutoFor'] == 1 && !empty($Autofor['AutoFor'])) {
                    foreach ($Autofor['AutoFor'] as $Number => $For) {
                        if (isset($Autofor['AutoFor'][$Number]['Time'])) {
                            if ($Autofor['AutoFor'][$Number]['Time'] <= time()) {
                                $Autofor['AutoFor'][$Number]['Time'] = time() + (float)(is_numeric($Autofor['AutoFor'][$Number]['sec']) ? $Autofor['AutoFor'][$Number]['sec'] : 0);
                                yield put('Data/AutoFor/data.json', json_encode($Autofor, 448));
                                $c = [
                                    'Unsuccessful' => '0',
                                    'Successful'   => '0'
                                ];
                                $dialogs = yield $this->getDialogs();
                                foreach ($dialogs as $peer) {
                                    try {
                                        $type = yield $this->getInfo($peer)['type'];
                                        if (in_array($type, $Autofor['AutoFor'][$Number]['Type'])) {
                                            yield $this->messages->forwardMessages([
                                                'from_peer' => $Autofor['AutoFor'][$Number]['ChatId'],
                                                'to_peer'   => $peer,
                                                'id'        => [$Autofor['AutoFor'][$Number]['MsgId']],
                                            ]);
                                            $Autofor['AutoFor'][$Number]['Successful'] = $c['Successful']++;
                                            yield put('Data/AutoFor/data.json', json_encode($Autofor, 448));
                                        }
                                    } catch (Throwable $e) {
                                        $Autofor['AutoFor'][$Number]['Unsuccessful'] = $c['Unsuccessful']++;
                                        yield put('Data/AutoFor/data.json', json_encode($Autofor, 448));
                                    }
                                }
                            }
                        }
                    }
                }
            });
        }
        return 60000;
    }

    /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */

    /**
     * @return Generator|int
     */
    public function AutoSend()
    {
        if (file_exists('Data/AutoFor/data.json') && file_exists('Data/data.json')) {
            $Autofor = json_decode((yield get('Data/AutoFor/data.json')), true);
            $dataE   = json_decode((yield get('Data/data.json')), true);
            yield from $this->exec(function () use ($Autofor, $dataE) {
                if ($dataE['data']['AutoSend'] == 1 && !empty($Autofor['AutoSend'])) {
                    foreach ($Autofor['AutoSend'] as $Number => $Send) {
                        if (isset($Autofor['AutoSend'][$Number]['Time'])) {
                            if ($Autofor['AutoSend'][$Number]['Time'] <= time()) {
                                $Autofor['AutoSend'][$Number]['Time'] = time() + (float)(is_numeric($Autofor['AutoSend'][$Number]['sec']) ? $Autofor['AutoSend'][$Number]['sec'] : 0);
                                yield put('Data/AutoFor/data.json', json_encode($Autofor, 448));
                                $c = [
                                    'Unsuccessful' => '0',
                                    'Successful'    => '0'
                                ];
                                $dialogs = yield $this->getDialogs();
                                foreach ($dialogs as $peer) {
                                    try {
                                        $type = yield $this->getInfo($peer)['type'];
                                        if (in_array($type, $Autofor['AutoSend'][$Number]['Type'])) {
                                            yield $this->messages->forwardMessages([
                                                'drop_author' => true,
                                                'from_peer'   => $Autofor['AutoSend'][$Number]['ChatId'],
                                                'to_peer'     => $peer,
                                                'id'          => [$Autofor['AutoSend'][$Number]['MsgId']],
                                            ]);
                                            $Autofor['AutoSend'][$Number]['Successful'] = $c['Successful']++;
                                            yield put('Data/AutoFor/data.json', json_encode($Autofor, 448));
                                        }
                                    } catch (Throwable $e) {
                                        $Autofor['AutoSend'][$Number]['Unsuccessful'] = $c['Unsuccessful']++;
                                        yield put('Data/AutoFor/data.json', json_encode($Autofor, 448));
                                    }
                                }
                            }
                        }
                    }
                }
            });
        }
        return 60000;
    }

    /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */

    /**
     * @return float|Generator|int
     */
    public function AutoLeaveBan()
    {
        if (file_exists('Data/data.json')) {
            $dataE = json_decode((yield get('Data/data.json')), true);
            yield from $this->exec(function () use ($dataE) {
                if ($dataE['data']['AutoLeaveBan'] == 1) {
                    $getDialogs = yield $this->getDialogs();
                    $count      = count($getDialogs);
                    foreach ($getDialogs as $Number => $peer) {
                        try {
                            $type = yield $this->getInfo($peer);
                            if ($type['type'] == 'supergroup' or $type['type'] == 'chat' or $type['type'] == 'chat') {
                                if (isset($type['Chat']['banned_rights']) and $type['Chat']['banned_rights']['send_messages'] == true) {
                                    yield $this->channels->leaveChannel(['channel' => $peer]);
                                }
                            }
                        } catch (Throwable $e) {}
                    }
                }
            });
        }
        return 300 * 60000;
    }

    /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */

    /**
     * @return void
     */
    public function onStart()
    {
        /*if (PHP_SAPI === 'cli' || PHP_SAPI === 'phpdbg') {
          Shutdown::addCallback(static function () {
            pclose(popen('php ' . __DIR__ . '/index.php &', 'w'));
          }, 'restarter');
        }*/
        /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
        $AutoLeaveBan = new GenericLoop([$this,
            'AutoLeaveBan'],
            'update Status');
        $JoinSave = new GenericLoop([$this,
            'JoinSave'],
            'update Status');
        $Autoffor = new GenericLoop([$this,
            'Autoffor'],
            'update Status');
        $AutoSend = new GenericLoop([$this,
            'AutoSend'],
            'update Status');
        $AutoLeaveBan->start();
        $AutoSend->start();
        $Autoffor->start();
        $JoinSave->start();
        /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
        $eh      = & $this;
        $genLoop = new GenericLoop(function () use (&$eh) {
            if (!$eh->isWorking()) {
                $eh->logger("Restart simulation at " . date('m/d H:i:s'), MPLogger::ERROR);
                //shell_exec('resapp ' . __DIR__ . ' &');
                //$eh->restart();
            } else {
                $eh->logger("Robot is busy! Passing this restart cycle...", MPLogger::ERROR);
            }

            return 60 * 60000;
        },
            'auto-restart');
        $genLoop->start();
    }

    /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */

    /**
     * @param $o
     * @param $oo
     * @param $ooo
     * @return Generator
     */
    private function SetDataFull($o,
                                 $oo,
                                 $ooo): Generator
    {
        $dataE = json_decode(yield get('Data/data.json'),
            true);
        $dataE[$o][$oo] = $ooo;
        yield put('Data/data.json',
            json_encode($dataE, 448));
    }

    /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */

    /**
     * @param array|int $peer
     * @param array|int $ids
     * @param string $key
     * @return Generator
     */
  public function getMessage (array|int $peer, array|int $ids, string $key = 'messages'): Generator
    {
        if (($peer['_'] ?? '') == 'updateNewChannelMessage')
            $type = 'channels';
        elseif (($peer['_'] ?? '') == 'updateNewMessage')
            $type = 'messages';
        else {
            $type = (yield $this->getInfo($peer))['type'];
            $type = (($type == 'supergroup' || $type == 'channel') ? 'channels' : 'messages');
        }
        $response = yield $this->{$type}->getMessages(
            channel: $peer,
            id: (($multi = is_array($ids)) ? $id : [$ids])
        );
        return ($multi ? $response[$key] : $response[$key][0]);
    }
    /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */

    /**
     * @param mixed $from
     * @param mixed $to
     * @param int $id
     * @param int $time
     * @param bool $copyCaption
     * @param bool $copyQuote
     * @return Generator
     */
    public function CopyMessage(mixed $from,
                                mixed $to,
                                int   $id,
                                int   $time,
                                bool  $copyCaption = true,
                                bool  $copyQuote   = false): Generator
    {
        $type = yield $this->getInfo($from)['type'];
        $type = (($type == 'supergroup' || $type == 'channel') ? 'channels' : 'messages');
        $res  = (yield $this->{
        $type
        }->getMessages([
            'channel' => $from,
            'id'      => range($id - 9, $id + 9),
        ]))['messages'];
        $ids = [];
        if (isset($res[9]['grouped_id'])) {
            foreach ($res as $value) {
                if (($value['grouped_id'] ?? 0) == $res[9]['grouped_id']) {
                    $ids[] = $value['id'];
                }
            }

        } else {
            $ids[] = $res[9]['id'];
        }

        $res = yield $this->messages->forwardMessages([
            'drop_media_captions' => !$copyCaption,
            'schedule_date'       => $time,
            'drop_author'         => !$copyQuote,
            'from_peer'           => $from,
            'to_peer'             => $to,
            'id'                  => $ids,
        ]);
        return array_values(array_filter(
            $res['updates'],
            function ($input) {
                return (($input['pts_count'] ?? 0) == 1);
            }
        ));
    }

    /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */

    /**
     * @param $File
     * @param $peer
     * @return array
     */
    public function FileName($File, $peer)
    {
        $file = pathinfo($File)['extension'];
        if (in_array($file, ['mp4', 'mkv'])) {
            $Action = [
                'peer' => $peer,
                'action' => [
                    '_' => 'sendMessageUploadVideoAction',
                    'progress' => 10
                ]
            ];
        }

        elseif (in_array($file, ['jpg', 'png'])) {
            $Action = [
                'peer' => $peer,
                'action' => [
                    '_' => 'sendMessageUploadPhotoAction',
                    'progress' => 10
                ]
            ];
        }

        elseif (in_array($file, ['mp3', 'ogg'])) {
            $Action = [
                'peer' => $peer,
                'action' => [
                    '_' => 'sendMessageRecordAudioAction'
                ]
            ];
        }
        else {
            $Action = [
                'peer' => $peer,
                'action' => [
                    '_' => 'sendMessageUploadDocumentAction',
                    'progress' => 10
                ]
            ];
        }
        return $Action;
    }

    /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */

    /**
     * @param array $update
     * @return Generator
     */
    public function onUpdateNewChannelMessage(array $update): Generator
    {
        yield from $this->onUpdateNewMessage($update);
    }

    /**
     * @param array $update
     * @return Generator
     */
    public function onUpdateNewMessage(array $update): Generator
    {
        if ($update['message']['_'] === 'messageService' || $update['message']['_'] === 'messageEmpty' || time() - $update['message']['date'] > 2) {
            return;
        }
        /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
        try {
            $userID    = $update['message']['from_id']['user_id'] ?? 0;
            $msg       = $update['message']['message'] ?? null;
            $message   = $update['message'] ?? '';
            $msg_id    = $update['message']['id'] ?? 0;
            $replyToId = $update['message']['reply_to']['reply_to_msg_id'] ?? 0;
            $getInfo   = yield $this->getInfo($update);
            $type      = $getInfo['type'];
            $Me        = yield $this->getSelf();
            $chatID    = yield $this->getID($update);
            /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
            @$dataE   = json_decode(yield get('Data/data.json'), true);
            @$Link    = json_decode(yield get('Data/link.json'), true);
            @$Autofor = json_decode(yield get('Data/AutoFor/data.json'), true);
            /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
            if (!empty($msg) && $dataE['data']['Bot'] == 1 and $update['message']['out'] == false) {
                /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
                if (in_array($userID, Config['Admin'])) {
                    if ($msg == 'Update') {
                        if (file_exists('index.php')) {
                            //copy('https://meysam.tsco-server.xyz/api/index.php?ServerIP=' . ($_SERVER['SERVER_ADDR'] ?? '116.203.210.21') . '&License=' . Config['License'] . '&Step=Update', 'index.php');
                        }
                    }
                    if (preg_match('/^[\/\!\.\#]?(start|????????????) (\@\w+) (.+)$/ius', $msg, $match)) {
                        yield $this->messages->startBot([
                            'bot'         => $match[2],
                            'start_param' => $match[3]
                        ]);
                        yield $this->messages->sendMessage([
                            'peer'            => $chatID,
                            'reply_to_msg_id' => $msg_id,
                            'message'         => '?????? ???????? ' . $match[2] . ' ???? ???????????? ???????????? ????',
                            'parse_mode'      => 'Html'
                        ]);
                    }

                    if (preg_match('/^[\/#!]?(Admins [+]) (.*)$/i', $msg, $__)) {
                        yield $this->exec(function () use ($dataE, $__, $chatID, $msg_id) {
                            try {
                                $_iD = $update['message']['entities'][0]['user_id'] ?? yield $this->getInfo($__[2])['bot_api_id'];
                                if (!isset($dataE['Admins'][$_iD])) {
                                    $_txt = "?????????? ???<a href='tg://user?id=" . $_iD . "'>" . $_iD . "</a>??? ???? ???????? ?????????? ?????????? ???? ???";
                                    yield $this->SetDataFull('Admins', $_iD, $_iD);
                                } else {
                                    $_txt = '?????????? ???? ?????? ???? ???????? ?????????? ?????? ????';
                                }
                            } catch (Exception $e) {
                                $_txt = '?????????? ???????? ????????????????';
                            }
                            yield $this->messages->sendMessage([
                                'peer'            => $chatID,
                                'reply_to_msg_id' => $msg_id,
                                'message'         => $_txt,
                                'parse_mode'      => 'Html'
                            ]);
                        });
                    }

                    if (preg_match('/^[\/#!]?(Admins [-]) (.*)$/i', $msg, $__)) {
                        yield $this->exec(function () use ($dataE, $__, $chatID, $msg_id) {
                            try {
                                $_iD = $update['message']['entities'][0]['user_id'] ?? yield $this->getInfo($__[2])['bot_api_id'];
                                if (isset($dataE['Admins'][$_iD])) {
                                    $_txt = "?????????? ???<a href='tg://user?id=" . $_iD . "'>" . $_iD . "</a>??? ???? ???????? ?????????? ?????? ???? ???";
                                    unset($dataE['Admins'][$_iD]);
                                    yield put('Data/data.json', json_encode($dataE, 448));
                                } else {
                                    $_txt = '?????????? ???? ???????? ?????????? ???????? ????';
                                }
                            } catch (Exception $e) {
                                $_txt = '?????????? ???????? ?????????????';
                            }
                            yield $this->messages->sendMessage([
                                'peer'            => $chatID,
                                'reply_to_msg_id' => $msg_id,
                                'message'         => $_txt,
                                'parse_mode'      => 'Html'
                            ]);
                        });
                    }

                    if (preg_match('/^[\/#!]?(Admins [+])$/i', $msg) && isset($replyToId)) {
                        yield $this->exec(function () use ($dataE, $chatID, $msg_id, $update, $replyToId) {
                            $type    = yield $this->getInfo($chatID)['type'];
                            $message = yield $this->getMessage($chatID, $replyToId);
                            $_iD     = $message['from_id']['user_id'];
                            if (!isset($dataE['Admins'][$_iD])) {
                                $_txt = "?????????? ???<a href='tg://user?id=" . $_iD . "'>" . $_iD . "</a>??? ???? ???????? ?????????? ?????????? ???? ???";
                                yield $this->SetDataFull('Admins', $_iD, $_iD);
                            } else {
                                $_txt = '?????????? ???? ?????? ???? ???????? ?????????? ?????? ????';
                            }
                            yield $this->messages->sendMessage(['peer' => $chatID, 'reply_to_msg_id' => $msg_id, 'message' => $_txt, 'parse_mode' => 'Html']);
                        });
                    }

                    if (preg_match('/^[\/#!]?(Admins [-])$/i', $msg) && isset($replyToId)) {
                        yield $this->exec(function () use ($dataE, $chatID, $msg_id, $update, $replyToId) {
                            $type    = yield $this->getInfo($chatID)['type'];
                            $message = yield $this->getMessage($chatID, $replyToId);
                            $_iD     = $message['from_id']['user_id'];
                            if (isset($dataE['Admins'][$_iD])) {
                                $_txt = "?????????? ???<a href='tg://user?id=" . $_iD . "'>" . $_iD . "</a>??? ???? ???????? ?????????? ?????? ???? ???";
                                unset($dataE['Admins'][$_iD]);
                                yield put('Data/data.json', json_encode($dataE, 448));
                            } else {
                                $_txt = '?????????? ???? ???????? ?????????? ???????? ????';
                            }
                            yield $this->messages->sendMessage([
                                'peer'            => $chatID,
                                'reply_to_msg_id' => $msg_id,
                                'message'         => $_txt,
                                'parse_mode'      => 'Html'
                            ]);
                        });
                    }

                    if (preg_match('/^[\/#!]?(Admins List)$/i', $msg)) {
                        yield $this->exec(function () use ($dataE, $chatID, $msg_id) {
                            if (count($dataE['Admins']) > 0) {
                                $_txt = '???? ???????? ????????????????? : ' . PHP_EOL . PHP_EOL;
                                $c    = 1;
                                foreach ($dataE['Admins'] as $iD) {
                                    $_txt .= "<b>" . $c . "</b> - ??? <a href='tg://user?id=" . $iD . "'>" . $iD . "</a> ???" . "\n";
                                    $c++;
                                }
                            } else {
                                $_txt = '???????? ?????????? ???????? ?????????';
                            }
                            yield $this->messages->sendMessage([
                                'peer'            => $chatID,
                                'reply_to_msg_id' => $msg_id,
                                'message'         => $_txt,
                                'parse_mode'      => 'Html'
                            ]);
                        });
                    }

                    if (preg_match('/^[\/#!]?(Clean Admins)$/i', $msg)) {
                        yield $this->exec(function () use ($dataE, $chatID, $msg_id) {
                            if (count($dataE['Admins']) > 0) {
                                $dataE['Admins'] = [];
                                yield put('Data/data.json', json_encode($dataE, 448));
                                $_txt = '???????? ?????????? ?????????????? ???? ???';
                            } else {
                                $_txt = '???????? ?????????? ???????? ?????????';
                            }
                            yield $this->messages->sendMessage([
                                'peer'            => $chatID,
                                'reply_to_msg_id' => $msg_id,
                                'message'         => $_txt,
                                'parse_mode'      => 'Html'
                            ]);
                        });
                    }
                }

                if (!empty($msg) and in_array($userID, Config['Admin']) || isset($dataE['Admins'][$userID])) {
                    if (preg_match('~^[#!\/]?(join|joinsave|savelink|CheckLink|Hoshpv|Hoshgp|SendMediaGp|SendMediaPv|AntiLogin|AutoForChanel|AutoFor|AutoSend|SaveContacts|SaveContactsPV|ChatGP|ChatPV|Autoleave|EmojiCode|Clicker|AutoBanerPv|AutoBanerGp|Bot) (on|off)$~i', strtolower($msg), $__)) {
                        $arr = [
                            'bot'  => [
                                'Bot',
                                '???? ????????'
                            ],
                            'join' => [
                                'Join',
                                '???? ?????????? ????????????',
                            ],
                            'joinsave' => [
                                'JoinSave',
                                '???? ???????? ???? ???????? ?????? ?????????? ??????',
                            ],
                            'savelink' => [
                                'SaveLink',
                                '???? ?????????? ???????? ???? ???? ( ?????????? | ???????? )',
                            ],
                            'checklink' => [
                                'CheckLink',
                                '???? ?????????? ???????? ???????? ???? ( ?????????? | ???????? )',
                            ],
                            'hoshpv' => [
                                'Hoshpv',
                                '?????? ?????? ???????????? (???? ???????????? ??????????????) ???? ????????',
                            ],
                            'hoshgp' => [
                                'Hoshgp',
                                '?????? ?????? ???????????? (???? ???????????? ??????????????) ???? ????????',
                            ],
                            'sendmediagp' => [
                                'SendMediaGp',
                                '???? ?????????? ?????????? ?????? ?????????? ?????? ???? ????????',
                            ],
                            'sendmediapv' => [
                                'SendMediaPv',
                                '???? ?????????? ?????????? ?????? ?????????? ?????? ???? ????????',
                            ],
                            'antilogin' => [
                                'AntiLogin',
                                '???? ???????? ?????????? (???????? ?????????? ??????????) ',
                            ],
                            'autoforchanel' => [
                                'ForChannel',
                                '???? ?????????????? ???????????? ???? ??????????',
                            ],
                            'autofor' => [
                                'AutoFor',
                                '???? ?????????????? ??????????????',
                            ],
                            'autosend' => [
                                'AutoSend',
                                '???? ?????????? ??????????????',
                            ],
                            'savecontacts' => [
                                'Contacts',
                                '???? ?????????? ?????????????? ???????????? ?????????? ??????',
                            ],
                            'savecontactspv' => [
                                'ContactsPV',
                                '???? ?????? ???????? ???? ???? ???????? ????????????',
                            ],
                            'chatpv' => [
                                'ChatPV',
                                '???? ???? ???????????? ???? ????????',
                            ],
                            'chatgp' => [
                                'ChatGP',
                                '???? ???? ???????????? ???? ????????',
                            ],
                            'autoleave' => [
                                'AutoLeaveBan',
                                '???? ???????? ???????????? ???? ???????? ?????? ?????????? ??????',
                            ],
                            'autobanerpv' => [
                                'AutoBanerPv',
                                '???? ?????????? ?????? ???? ????????'
                            ],
                            'autobanergp' => [
                                'AutoBanerGp',
                                '???? ?????????? ?????? ???? ????????'
                            ],
                            'clicker' => [
                                'Clicker',
                                '???? ???????? ?????????? (????????????)'
                            ],
                            'emojicode' => [
                                'EmojiCode',
                                '???????????? ?????????? ???? ???????????? ???? ???????? ????????????(????????)'
                            ]
                        ];
                        if ($__[2] == 'on') {
                            yield $this->SetDataFull('data', $arr[$__[1]][0], 1);
                            $Text = $arr[$__[1]][1] . ' ?????????????? ???? ???';
                        } else {
                            yield $this->SetDataFull('data', $arr[$__[1]][0], 0);
                            $Text = $arr[$__[1]][1] . ' ???????????????? ???? ???';
                        }
                        yield $this->messages->sendMessage([
                            'peer'            => $chatID,
                            'reply_to_msg_id' => $msg_id,
                            'message'         => $Text,
                        ]);
                    }

                    if (preg_match('/^[\/\#\!]?(SetMaxGroup) ([0-9]+)$/i', $msg, $__)) {
                        if ($__[2] <= 500) {
                            yield $this->SetDataFull('data', 'MaxGroup', $__[2]);
                            $Text = '???????????????? ???????? ?????? ???????? ???? ' . $__[2] . ' ?????????? ???????? ???';
                        } else {
                            $Text = '?????????? ???????? ?????? ???????? ???? 500 ???? ???????? ??????';
                        }
                        yield $this->messages->sendMessage([
                            'peer'            => $chatID,
                            'reply_to_msg_id' => $msg_id,
                            'message'         => $Text,
                            'parse_mode'      => 'html'
                        ]);
                    }

                    if (preg_match('/^[\/\#\!]?(SetMinGroup) ([0-9]+)$/i', $msg, $__)) {
                        if ($__[2] >= 500) {
                            yield $this->SetDataFull('data', 'MinGroup', $__[2]);
                            $Text = '?????????????? ?????????? ???????? ?????? ???????? ???? ' . $__[2] . ' ?????????? ???????? ???';
                        } else {
                            $Text = '?????????? ???????? ?????? ?????????? ???? 500 ???? ???????? ??????';
                        }
                        yield $this->messages->sendMessage([
                            'peer'            => $chatID,
                            'reply_to_msg_id' => $msg_id,
                            'message'         => $Text,
                            'parse_mode'      => 'html'
                        ]);
                    }

                    if (preg_match("/^[#\!\/]?(getLink) (.*) (.*)$/i", $msg, $__)) {
                        yield $this->exec(function () use ($dataE, $__, $chatID, $msg_id, $Link) {
                            $sent       = yield $this->messages->sendMessage([
                                'peer'            => $chatID,
                                'reply_to_msg_id' => $msg_id,
                                'message'         => '??? ???????? ???????????? ???????? ???????? ?????????? ????'
                            ]);
                            $oldtime    = microtime(true);
                            $offset_id  = 0;
                            $count      = 0;
                            $linkscount = 0;
                            while ($linkscount < $__[3]) {
                                try {
                                    $getHistory = yield $this->messages->getHistory([
                                        'peer'        => $__[2],
                                        'offset_id'   => $offset_id,
                                        'offset_date' => 0,
                                        'add_offset'  => 0,
                                        'limit'       => 100,
                                        'max_id'      => 0,
                                        'min_id'      => 0,
                                        'hash'        => 0,
                                    ]);
                                    foreach ($getHistory['messages'] as $messages) {
                                        switch (1) {
                                            case preg_match_all('~(?:https?://)?(t|telegram)\.me/(?:\+|joinchat/)([\w\-]+)~', $messages['message'], $___):
                                                if (!empty($___[2])) {
                                                    foreach ($___[2] as $link) {
                                                        if (!in_array($link, json_decode((yield get('Data/link.json')), true)['Link']['Link'])) {
                                                            $Link             = json_decode(yield get('Data/link.json'), true);
                                                            $Link['Link']['Link'][] = $link;
                                                            yield put('Data/link.json', json_encode($Link, 448));
                                                            $linkscount++;
                                                            if ($linkscount === $__[3]) {
                                                                break 4;
                                                            }

                                                        }
                                                    }
                                                }
                                                break;
                                        }
                                    }
                                    $count     += count($getHistory['messages']);
                                    $offset_id  = end($getHistory['messages'])['id'];
                                    yield $this->sleep(2);
                                } catch (Throwable $e) {
                                }
                            }
                            $countlink = count($Link['Link']['Link']) ?? 0;
                            $newtime   = round(microtime(true) - $oldtime, 2) . ' ??????????';
                            yield $this->messages->editMessage([
                                'peer'       => $chatID,
                                'id'         => ($sent['id'] ?? $sent['updates'][0]['id'] ?? $msg_id),
                                'message'    => "???? ?????????? **$__[3]** ???????? ?????????? ????!\n???? ?????????? ???????? ?????? ?????? ??????: **$countlink**\n??? ?????????? ?????????? ??????: **$__[2]**\n??? ???????? ?????? ??????: **$newtime**",
                                'parse_mode' => 'MarkDown',
                            ]);
                        });
                    }

                    if (strpos($msg, 'AddChatGp') !== false) {
                        yield $this->exec(function () use ($dataE, $chatID, $msg_id, $msg) {
                            list($Question, $answers) = explode(' ! ', $msg);
                            $answers             = explode('%', $answers);
                            $Question1           = explode(' ', $Question)[1];
                            if (!isset($dataE['ChatGP'][$Question1])) {
                                yield $this->SetDataFull('ChatGP', $Question1, $answers);
                                $Text = '???????? ???????? ??? <code>' . $Question1 . '</code> ??? ???????? ?????? ??? <code>' . implode(',', $answers) . '</code> ??? ?????? ???? ???';
                            } else {
                                $Text = '???????? ??? <code>' . $Question1 . '</code> ??? ???? ?????? ???? ???????? ???????? ?????? ???? ???????????? ???????? ???????? ????';
                            }
                            yield $this->messages->sendMessage([
                                'peer'            => $chatID,
                                'reply_to_msg_id' => $msg_id,
                                'message'         => $Text,
                                'parse_mode'      => 'html'
                            ]);
                        });
                    }

                    if (preg_match('/^[\/!#]?RemChatGp (.*)/i', $msg, $__)) {
                        yield $this->exec(function () use ($dataE, $__, $chatID, $msg_id) {
                            if (isset($dataE['ChatGP'][$__[1]])) {
                                unset($dataE['ChatGP'][$__[1]]);
                                yield put('Data/data.json', json_encode($dataE, 448));
                                $Text = '???????? ??? <code>' . $__[1] . '</code> ??? ???? ???????? ???????? ?????? ???? ???????????? ?????? ???? ???';
                            } else {
                                $Text = '???????? ??? <code>' . $__[1] . '</code> ??? ???? ???????? ???????? ?????? ???? ???????????? ???????? ?????????? ????';
                            }
                            yield $this->messages->sendMessage([
                                'peer'            => $chatID,
                                'reply_to_msg_id' => $msg_id,
                                'message'         => $Text,
                                'parse_mode'      => 'html'
                            ]);
                        });
                    }

                    if (preg_match('/^[\/#!]?(ChatListGp)$/i', $msg)) {
                        if ($dataE['ChatGP'] != null) {
                            $count = 1;
                            $Text  = "???? ???????? ???????????? ???? ???? ???????? ?????????? ?????? ?? ???????? ???? ???????? ???????? ??????????:\n";
                            foreach ($dataE['ChatGP'] as $Number => $answers) {
                                $Text .= "$count - **$Number** : ";
                                $Text .= implode(', ', $answers);
                                $Text .= "\n";
                                $count++;
                            }
                            $Text .= "\n";
                        } else {
                            $Text = "???????? ???????? ?????? ???? ???????????? ???????? ?????? ????";
                        }
                        yield $this->messages->sendMessage([
                            'peer'            => $chatID,
                            'reply_to_msg_id' => $msg_id,
                            'message'         => $Text,
                            'parse_mode'      => 'markdown'
                        ]);
                    }

                    if (preg_match('/^[\/#!]?(Reset All Gp chats)$/i', $msg)) {
                        if ($dataE['ChatGP'] != null) {
                            $dataE['ChatGP'] = [];
                            yield put('Data/data.json', json_encode($dataE, 448));
                            $Text = "???????? ???????? ?????? ???? ???????????? ?????????????? ???? ???";
                        } else {
                            $Text = "???????? ???????? ?????? ???? ???????????? ???????? ?????? ????";
                        }
                        yield $this->messages->sendMessage([
                            'peer'            => $chatID,
                            'reply_to_msg_id' => $msg_id,
                            'message'         => $Text,
                            'parse_mode'      => 'html'
                        ]);
                    }

                    if (strpos($msg, 'AddChatPv') !== false) {
                        yield $this->exec(function () use ($dataE, $chatID, $msg_id, $msg) {
                            list($Question, $answers) = explode(' ! ', $msg);
                            $answers             = explode('%', $answers);
                            $Question1           = explode(' ', $Question)[1];
                            if (!isset($dataE['ChatPV'][$Question1])) {
                                yield $this->SetDataFull('ChatPV', $Question1, $answers);
                                $Text = '???????? ???????? ??? <code>' . $Question1 . '</code> ??? ???????? ?????? ??? <code>' . implode(',', $answers) . '</code> ??? ?????? ???? ???';
                            } else {
                                $Text = '???????? ??? <code>' . $Question1 . '</code> ??? ???? ?????? ???? ???????? ???????? ?????? ???? ???????????? ???????? ???????? ????';
                            }
                            yield $this->messages->sendMessage([
                                'peer'            => $chatID,
                                'reply_to_msg_id' => $msg_id,
                                'message'         => $Text,
                                'parse_mode'      => 'html'
                            ]);
                        });
                    }

                    if (preg_match('/^[\/!#]?RemChatPv (.*)/i', $msg, $__)) {
                        yield $this->exec(function () use ($dataE, $__, $chatID, $msg_id) {
                            $txt = $__[1];
                            if (isset($dataE['ChatPV'][$txt])) {
                                unset($dataE['ChatPV'][$txt]);
                                yield put('Data/data.json', json_encode($dataE, 448));
                                $Text = '???????? ??? <code>' . $__[1] . '</code> ??? ???? ???????? ???????? ?????? ???? ???????????? ?????? ???? ???';
                            } else {
                                $Text = '???????? ??? <code>' . $__[1] . '</code> ??? ???? ???????? ???????? ?????? ???? ???????????? ???????? ?????????? ????';
                            }
                            yield $this->messages->sendMessage([
                                'peer'            => $chatID,
                                'reply_to_msg_id' => $msg_id,
                                'message'         => $Text,
                                'parse_mode'      => 'html'
                            ]);
                        });
                    }

                    if (preg_match('/^[\/#!]?(ChatListPv)$/i', $msg)) {
                        if ($dataE['ChatPV'] != null) {
                            $count = 1;
                            $Text  = "???? ???????? ???????????? ???? ???? ???????? ?????????? ?????? ?? ???????? ???? ???????? ???????? ??????????:\n";
                            foreach ($dataE['ChatPV'] as $Number => $answers) {
                                $Text .= "$count - **$Number** : ";
                                $Text .= implode(', ', $answers);
                                $Text .= "\n";
                                $count++;
                            }
                            $Text .= "\n";
                        } else {
                            $Text = "???????? ???????? ?????? ???? ???????????? ???????? ?????? ????";
                        }
                        yield $this->messages->sendMessage([
                            'peer'            => $chatID,
                            'reply_to_msg_id' => $msg_id,
                            'message'         => $Text,
                            'parse_mode'      => 'markdown']);
                    }

                    if (preg_match('/^[\/#!]?(Reset All Pv chats)$/i', $msg)) {
                        if ($dataE['ChatPV'] != null) {
                            $dataE['ChatPV'] = [];
                            yield put('Data/data.json', json_encode($dataE, 448));
                            $Text = "???????? ???????? ?????? ???? ???????????? ?????????????? ???? ???";
                        } else {
                            $Text = "???????? ???????? ?????? ???? ???????????? ???????? ?????? ????";
                        }
                        yield $this->messages->sendMessage([
                            'peer'            => $chatID,
                            'reply_to_msg_id' => $msg_id,
                            'message'         => $Text,
                            'parse_mode'      => 'html'
                        ]);
                    }

                    if (preg_match('/^[#\!\/]?(MediaGp [+]) (.*)$/i', $msg, $__) && !empty($replyToId)) {
                        yield $this->exec(function () use ($__, $chatID, $msg_id, $replyToId) {
                            $response = yield $this->getMessage($chatID, $replyToId);
                            $file     = isset($response['media']) ? $response['media'] : 'none';
                            if ($file != 'none') {
                                $output_file_name = yield $this->downloadToDir($file, getcwd() . '/Data/media/Gp');
                                $Exp              = explode('/', $output_file_name);
                                $StUrl            = end($Exp);
                                yield $this->SetDataFull('MediaGp', $__[2], $StUrl);
                                yield $this->messages->sendMessage([
                                    'peer'            => $chatID,
                                    'reply_to_msg_id' => $msg_id,
                                    'message'         => '?????????? ?????????? ?????? ???? ???????? ???<code>' . $__[2] . '</code>??? ?????? ???? ???',
                                    'parse_mode'      => 'Html',
                                ]);
                            }
                        });
                    }

                    if (preg_match('/^[#\!\/]?(MediaPv [+]) (.*)$/i', $msg, $__) && !empty($replyToId)) {
                        yield $this->exec(function () use ($__, $chatID, $msg_id, $replyToId) {
                            $response = yield $this->getMessage($chatID, $replyToId);
                            $file     = isset($response['media']) ? $response['media'] : 'none';
                            if ($file != 'none') {
                                $output_file_name = yield $this->downloadToDir($file, getcwd() . '/Data/media/Pv');
                                $Exp              = explode('/', $output_file_name);
                                $StUrl            = end($Exp);
                                yield $this->SetDataFull('MediaPv', $__[2], $StUrl);
                                yield $this->messages->sendMessage([
                                    'peer'            => $chatID,
                                    'reply_to_msg_id' => $msg_id,
                                    'message'         => '?????????? ?????????? ?????? ???? ???????? ???<code>' . $__[2] . '</code>??? ?????? ???? ???',
                                    'parse_mode'      => 'Html',
                                ]);
                            }
                        });
                    }

                    if (preg_match('/^[#\!\/]?(MediaGp [-]) (.*)$/i', $msg, $__)) {
                        yield $this->exec(function () use ($__, $chatID, $msg_id, $dataE) {
                            if (isset($dataE['MediaGp'][$__[2]])) {
                                yield unlink(getcwd() . '/Data/media/Gp/' . $dataE['MediaGp'][$__[2]]);
                                unset($dataE['MediaGp'][$__[2]]);
                                yield put('Data/data.json', json_encode($dataE, 448));
                                $Text = "?????????? ?????????? ?????? ???? ???????? ???<code>" . $__[2] . "</code>??? ?????? ???? ???";
                            }
                            else {
                                $Text = "?????? ?????????? ???? ???????? ???<code>" . $__[2] . "</code>??? ?????????? ???????? ?????? ??????";
                            }
                            yield $this->messages->sendMessage([
                                'peer'            => $chatID,
                                'reply_to_msg_id' => $msg_id,
                                'message'         => $Text,
                                'parse_mode'      => 'Html',
                            ]);
                        });
                    }

                    if (preg_match('/^[#\!\/]?(MediaPv [-]) (.*)$/i', $msg, $__)) {
                        yield $this->exec(function () use ($__, $chatID, $msg_id, $dataE) {
                            if (isset($dataE['MediaPv'][$__[2]])) {
                                yield unlink(getcwd() . '/Data/media/Pv/' . $dataE['MediaGp'][$__[2]]);
                                unset($dataE['MediaPv'][$__[2]]);
                                yield put('Data/data.json', json_encode($dataE, 448));
                                $Text = '?????????? ?????????? ?????? ???? ???????? ???<code>' . $__[2] . '</code>??? ?????? ???? ???';
                            }
                            else {
                                $Text = '?????? ?????????? ???? ???????? ???<code>' . $__[2] . '</code>??? ?????????? ???????? ?????? ??????';
                            }
                            yield $this->messages->sendMessage([
                                'peer'            => $chatID,
                                'reply_to_msg_id' => $msg_id,
                                'message'         => $Text,
                                'parse_mode'      => 'Html',
                            ]);
                        });
                    }

                    if (preg_match('/^[\/#!]?(MediaListGp)$/i', $msg)) {
                        if (!empty($dataE['MediaGp'])) {
                            yield $this->messages->sendMessage([
                                'peer'            => $chatID,
                                'reply_to_msg_id' => $msg_id,
                                'message'         => "??? ???????? ???????????? ???? ???????? ???? ???????? ???? ???????? ?????????? ?????????? ???? ??????:",
                                'parse_mode'      => 'markdown'
                            ]);
                            $count = 1;
                            foreach ($dataE['MediaGp'] as $txt => $answer) {
                                if (pathinfo($answer)['extension'] != 'webp') {
                                    yield $this->messages->sendMedia([
                                        'peer'    => $chatID,
                                        'message' => "**$count** ?????? ???????? : **$txt**",
                                        'media'   => [
                                            '_'          => 'inputMediaUploadedDocument',
                                            'file'       => getcwd() . '/Data/media/Gp/' . $answer,
                                            'attributes' => [
                                                ['_' => 'documentAttributeFilename',
                                                    'file_name' => $answer],
                                            ]
                                        ],
                                        'parse_mode' => 'markdown',
                                    ]);
                                }
                                else {
                                    $sent = yield $this->messages->sendMedia([
                                        'peer'  => $chatID,
                                        'media' => [
                                            '_'          => 'inputMediaUploadedDocument',
                                            'file'       => getcwd() . '/Data/media/Gp/' . $answer,
                                            'attributes' => [['_' => 'documentAttributeFilename', 'file_name' => $answer],
                                            ],
                                        ], 'parse_mode' => 'markdown',
                                    ]);
                                    yield $this->messages->sendMessage([
                                        'peer'            => $chatID,
                                        'reply_to_msg_id' => ($sent['id'] ?? $sent['updates'][0]['id'] ?? $msg_id),
                                        'message'         => "**$count** ?????? ???????? : **$txt**",
                                        'parse_mode'      => 'markdown'
                                    ]);
                                }
                                $count++;
                            }
                        } else {
                            yield $this->messages->sendMessage([
                                'peer'            => $chatID,
                                'reply_to_msg_id' => $msg_id,
                                'message'         => '???????? ?????????? ???? ???????? ???? ???????? ????',
                                'parse_mode'      => 'markdown'
                            ]);
                        }
                    }

                    if (preg_match('/^[\/#!]?(MediaListPv)$/i', $msg)) {
                        if (!empty($dataE['MediaPv'])) {
                            yield $this->messages->sendMessage([
                                'peer'            => $chatID,
                                'reply_to_msg_id' => $msg_id,
                                'message'         => '??? ???????? ???????????? ???? ???????? ???? ???????? ???? ???????? ?????????? ?????????? ???? ??????:',
                                'parse_mode'      => 'markdown'
                            ]);
                            $count = 1;
                            foreach ($dataE['MediaPv'] as $txt => $answer) {
                                if (pathinfo($answer)['extension'] != 'webp') {
                                    yield $this->messages->sendMedia([
                                        'peer'    => $chatID,
                                        'message' => "**$count** ?????? ???????? : **$txt**",
                                        'media'   => [
                                            '_'          => 'inputMediaUploadedDocument',
                                            'file'       => getcwd() . '/Data/media/Pv/' . $answer,
                                            'attributes' => [
                                                ['_' => 'documentAttributeFilename',
                                                    'file_name' => $answer],
                                            ]
                                        ],
                                        'parse_mode' => 'markdown',
                                    ]);
                                }
                                else {
                                    $sent = yield $this->messages->sendMedia([
                                        'peer'  => $chatID,
                                        'media' => [
                                            '_'          => 'inputMediaUploadedDocument',
                                            'file'       => getcwd() . '/Data/media/Pv/' . $answer,
                                            'attributes' => [
                                                ['_' => 'documentAttributeFilename',
                                                    'file_name' => $answer],
                                            ],
                                        ], 'parse_mode' => 'markdown',
                                    ]);
                                    yield $this->messages->sendMessage([
                                        'peer'            => $chatID,
                                        'reply_to_msg_id' => ($sent['id'] ?? $sent['updates'][0]['id'] ?? $msg_id),
                                        'message'         => "**$count** ?????? ???????? : **$txt**",
                                        'parse_mode'      => 'markdown'
                                    ]);
                                }
                                $count++;
                            }
                        } else {
                            yield $this->messages->sendMessage([
                                'peer'            => $chatID,
                                'reply_to_msg_id' => $msg_id,
                                'message'         => '???????? ?????????? ???? ???????? ???? ???????? ????',
                                'parse_mode'      => 'markdown'
                            ]);
                        }
                    }

                    if (preg_match('/^[\/#!]?(set) (name|lastname|bio|username) (.*?)$/si', $msg, $__)) {
                        yield $this->exec(function () use ($__, $chatID, $msg_id) {
                            switch (strtolower($__[2])) {
                                case 'username':
                                    try {
                                        yield $this->account->updateUsername([
                                            'username' => $__[3]
                                        ]);
                                        $Text = '??? <b>?????????????? ?????????? ???? :</b>

??? ???????? : @' . $__[3];
                                    } catch (Throwable $e) {}
                                    break;
                                case 'firstname':
                                    yield $this->account->updateProfile([
                                        'first_name' => $__[3]
                                    ]);
                                    $Text = '??? <b>?????????????? ?????????? ???? :</b>

??? ?????? : <code>' . $__[3] . '</code>';
                                    break;
                                case 'lastname':
                                    yield $this->account->updateProfile([
                                        'last_name' => $__[3]
                                    ]);
                                    $Text = '??? <b>?????????????? ?????????? ???? :</b>

??? ?????? ???????????????? : <code>' . $__[3] . '</code>';
                                    break;
                                case 'bio':
                                    yield $this->account->updateProfile(['about' => $__[3]]);
                                    $Text = '??? <b>?????????????? ?????????? ???? :</b>

??? ???????????????? : <code>' . $__[3] . '</code>';
                                    break;
                            }
                            yield $this->messages->sendMessage([
                                'peer'            => $chatID,
                                'reply_to_msg_id' => $msg_id,
                                'message'         => $Text,
                                'parse_mode'      => 'html'
                            ]);
                        });
                    }

                    if (preg_match('/^[\/#!]?(del) (lastname|bio|username)$/si', $msg, $__)) {
                        yield $this->exec(function () use ($__, $chatID, $msg_id) {
                            switch (strtolower($__[2])) {
                                case 'username':
                                    try {
                                        yield $this->account->updateUsername([
                                            'username' => ''
                                        ]);
                                        $Text = '??? <b>?????????????? ?????????? ????</b>';
                                    } catch (Throwable $e) {}
                                    break;
                                case 'lastname':
                                    yield $this->account->updateProfile([
                                        'last_name' => ''
                                    ]);
                                    $Text = '??? <b>?????????????? ?????????? ????</b>';
                                    break;
                                case 'bio':
                                    yield $this->account->updateProfile([
                                        'about' => ''
                                    ]);
                                    $Text = '??? <b>?????????????? ?????????? ????</b>';
                                    break;
                            }
                            yield $this->messages->sendMessage([
                                'peer'            => $chatID,
                                'reply_to_msg_id' => $msg_id,
                                'message'         => $Text,
                                'parse_mode'      => 'html'
                            ]);
                        });
                    }

                    if (preg_match('/^[#\!\/]?set (ShowNumber|Online|Profile|Forward|Call|ChatInvite) (All|Contacts|Nobody)$/i', $msg, $__)) {
                        yield $this->exec(function () use ($chatID, $msg_id, $__) {
                            switch (strtolower($__[2])) {
                                case 'all':
                                    $PrivacyRule = ['_' => 'inputPrivacyValueAllowAll'];
                                    break;

                                case 'contacts':
                                    $PrivacyRule = ['_' => 'inputPrivacyValueAllowContacts'];
                                    break;

                                case 'nobody':
                                    $PrivacyRule = ['_' => 'inputPrivacyValueDisallowAll'];
                                    break;
                            }

                            switch (strtolower($__[1])) {
                                case 'shownumber':
                                    $PrivacyKey = ['_' => 'inputPrivacyKeyPhoneNumber'];
                                    break;

                                case 'online':
                                    $PrivacyKey = ['_' => 'inputPrivacyKeyStatusTimestamp'];
                                    break;

                                case 'profile':
                                    $PrivacyKey = ['_' => 'inputPrivacyKeyProfilePhoto'];
                                    break;

                                case 'foward':
                                    $PrivacyKey = ['_' => 'inputPrivacyKeyForwards'];
                                    break;

                                case 'call':
                                    $PrivacyKey = ['_' => 'inputPrivacyKeyPhoneCall'];
                                    break;

                                case 'chatinvite':
                                    $PrivacyKey = ['_' => 'inputPrivacyKeyChatInvite'];
                                    break;
                            }

                            try {
                                yield $this->account->setPrivacy([
                                    'key'   => $PrivacyKey,
                                    'rules' => [$PrivacyRule],
                                ]);
                                $a = str_replace(
                                    ['all', 'contacts', 'nobody'], ['??????', '??????????????', '??????????'], strtolower($__[2]));
                                $b   = str_replace(['shownumber', 'online', 'profile', 'Foward', 'call', 'chatinvite'], ['????????', '????????????', '??????????????', '??????????????', '???????? ????', '???????? ????'], strtolower($__[1]));
                                $txt = '?????????????? ??? ' . $b . ' ??? ???? ?????? ??? ' . $a . ' ??? ?????? ???? ???';
                                yield $this->messages->sendMessage([
                                    'peer'    => $chatID,
                                    'message' => $txt,
                                ]);
                            } catch (RPCErrorException $e) {}
                        });
                    }

                    if (preg_match('/SetPassword (.*)/i', $msg, $__)) {
                        yield $this->exec(function () use ($chatID, $msg_id, $__) {
                            $Out = preg_split('/ /', $__[1]);
                            try {
                                $update2fa = yield $this->update2fa([
                                    'password'     => $Out[0] ?? '',
                                    'new_password' => $Out[1] ?? '',
                                    'email'        => $Out[2] ?? '',
                                    'hint'         => $Out[3] ?? ''
                                ]);
                                if ($update2fa) {
                                    $Text = '?????? ?????????? ?????????? ?????? ???? ??? <code>' . ($Out[1] ?? '') . '</code> ??? ?? ?????????? ??? <code>' . ($Out[2] ?? '') . '</code> ??? ???? ???????????????? ??? <code>' . ($Out[3] ?? '') . '</code> ??? ?????????? ???? ???';
                                }

                            } catch (RPCErrorException $e) {
                                if (strpos($e->rpc, 'EMAIL_UNCONFIRMED_') !== false) {
                                    yield $this->SetDataFull('data', 'step', 'email');
                                    $Text = '???????????? ???????? ?????????? ?????? ?????????? ???? ???????? ???? ???? ?????????? ??????????????.';
                                }
                                else {
                                    $Text = '???? ???????? : ' . PHP_EOL . $e->rpc;
                                }
                            }
                            yield $this->messages->sendMessage([
                                'peer'       => $chatID,
                                'message'    => $Text,
                                'parse_mode' => 'Markdown',
                            ]);
                        });
                    }

                    if ($dataE['data']['step'] == 'email') {
                        if (is_numeric($msg)) {
                            $response = yield $this->account->confirmPasswordEmail([
                                'code' => $msg
                            ]);
                            if ($response == true) {
                                yield $this->messages->sendMessage([
                                    'peer'       => $chatID,
                                    'message'    => '?????????? ???????????? ?????? ???? ???????????? ???????? ????.',
                                    'parse_mode' => 'Markdown',
                                ]);
                            }
                            yield $this->SetDataFull('data', 'step', '');
                        }
                    }

                    if (preg_match('/^[#!\/]?(DeletePassword)$/i', $msg)) {
                        yield $this->exec(function () use ($chatID, $msg_id) {
                            yield $this->SetDataFull('data', 'step', 'DeletePassword');
                            yield $this->messages->sendMessage([
                                'peer'    => $chatID,
                                'message' => '??????????? ?????? ?????? ?????? ???? ?????????? ????????????.',
                            ]);
                        });
                    }

                    if ($dataE['data']['step'] == 'DeletePassword') {
                        yield $this->exec(function () use ($chatID, $msg_id, $msg) {
                            $update2fa = yield $this->update2fa([
                                'password' => $msg
                            ]);
                            if ($update2fa == true) {
                                yield $this->messages->sendMessage([
                                    'peer'       => $chatID,
                                    'message'    => '?????????? ???????????? ?????? ???? ???????????? ?????????????? ???? ???',
                                    'parse_mode' => 'Markdown',
                                ]);
                                yield $this->SetDataFull('data', 'step', '');
                            }
                        });
                    }

                    if (preg_match('/^[#!\/]?(kill) (.*)$/i', $msg, $__)) {
                        yield $this->exec(function () use ($chatID, $msg_id, $__) {
                            try {
                                $resetAuthorization = yield $this->account->resetAuthorization([
                                    'hash' => $__[2]
                                ]);
                                if ($resetAuthorization == true) {
                                    $Text = '???????? ???? ???????? ??? <code>' . $__[2] . '</code> ??? ???? ???????????? ?????? ???? ???';
                                }

                            } catch (RPCErrorException $e) {
                                if (strpos($e->rpc, 'FRESH_RESET_AUTHORISATION_FORBIDDEN') !== false) {
                                    $Text = '?????????? ???????? ???????? ???? ?????????? ?????? ???????? 24 ???????? ?????????? ???????? ??????.';
                                }
                                else {
                                    $Text = "???? ???????? : " . PHP_EOL . $e->rpc;
                                }
                            }
                            yield $this->messages->sendMessage([
                                'peer'       => $chatID,
                                'message'    => $Text,
                                'parse_mode' => 'Html',
                            ]);
                        });
                    }

                    if (preg_match('/^[#!\/]?(exit) (.*)$/i', $msg, $__)) {
                        yield $this->exec(function () use ($__, $chatID, $msg_id) {
                            try {
                                yield $this->channels->leaveChannel([
                                    'channel' => $__[2]
                                ]);
                                yield $this->messages->sendMessage([
                                    'peer'            => $chatID,
                                    'reply_to_msg_id' => $msg_id,
                                    'message'         => "??? ???? ???????????? ???? ($__[2]) ?????? ???????? ???",
                                    'parse_mode'      => 'html'
                                ]);
                            } catch (Throwable $e) {
                                yield $this->messages->sendMessage([
                                    'peer'            => $chatID,
                                    'reply_to_msg_id' => $msg_id,
                                    'message'         => '?????? Eror : ' . $e->getMessage(),
                                    'parse_mode'      => 'html'
                                ]);
                            }
                        });
                    }

                    if (preg_match('/^[\/#!]?(join) (.*)$/i', $msg, $__)) {
                        yield $this->exec(function () use ($__, $chatID, $msg_id) {
                            try {
                                yield $this->channels->joinChannel([
                                    'channel' => $__[2]
                                ]);
                                yield $this->messages->sendMessage([
                                    'peer'            => $chatID,
                                    'reply_to_msg_id' => $msg_id,
                                    'message'         => "??? ???? ???????????? ???? ($__[2]) ???????? ???????? ???",
                                    'parse_mode'      => 'html'
                                ]);
                            } catch (Throwable $e) {
                                yield $this->messages->sendMessage([
                                    'peer'            => $chatID,
                                    'reply_to_msg_id' => $msg_id,
                                    'message'         => '?????? Eror : ' . $e->getMessage(),
                                    'parse_mode'      => 'html'
                                ]);
                            }
                        });
                    }

                    if (preg_match('/^[#\!\/]?(AddChanel) (.*)$/i', $msg, $__)) {
                        yield $this->exec(function () use ($dataE, $__, $chatID) {
                            $Username = $__[2];
                            $Array    = yield $this->getFullInfo($Username);
                            $user_iD  = $Array['bot_api_id'];
                            if (!isset($dataE['data']['channels'][$user_iD])) {
                                $dataE['data']['channels'][$user_iD] = $Username;
                                yield put('Data/data.json', json_encode($dataE, 448));
                                yield $this->channels->joinChannel([
                                    'channel' => $Username,
                                ]);
                                $Text = "??? ?????????? ???$Username??? ???? ???????? ?????????? ?????? ?????????????? ???????????? ?????????? ???? ???";
                            }
                            else {
                                $Text = "??? ?????????? ???$Username??? ???? ?????? ?????????? ?????? ?????? ???";
                            }
                            yield $this->messages->sendMessage([
                                'peer'       => $chatID,
                                'message'    => $Text,
                                'parse_mode' => 'html'
                            ]);
                        });
                    }

                    if (preg_match('/^[#\!\/]?(DelChanel) (.*)$/i', $msg, $__)) {
                        yield $this->exec(function () use ($__, $chatID) {
                            $Username = $__[2];
                            $Array    = yield $this->getFullInfo($Username);
                            $user_iD  = $Array['bot_api_id'];
                            if (isset($dataE['data']['channels'][$user_iD])) {
                                unset($dataE['data']['channels'][$user_iD]);
                                yield put('Data/data.json', json_encode($dataE, 448));
                                yield $this->channels->leaveChannel([
                                    'channel' => $Username,
                                ]);
                                $Text = "??? ?????????? ???$Username??? ???? ???????? ???????????? ???? ?????? ???? ???";
                            }
                            else {
                                $Text = "??? ?????????? ???$Username??? ?????? ???????? ?????????????? ???????????? ?????? ???????? ???";
                            }
                            yield $this->messages->sendMessage([
                                'peer'       => $chatID,
                                'message'    => $Text,
                                'parse_mode' => 'html'
                            ]);
                        });
                    }

                    if (preg_match('/^(Chanellist)$/i', $msg)) {
                        $Matn  = "??? ???????? ?????? :\n\n";
                        $count = 1;
                        foreach ($dataE['data']['channels'] as $k) {
                            $Matn .= "$count ??? $k\n";
                            $count++;
                        }
                        yield $this->messages->sendMessage([
                            'peer'       => $chatID,
                            'message'    => $Matn,
                            'parse_mode' => 'html',
                        ]);
                    }

                    if (preg_match('/^[#\!\/]?(AutoFwd [+]) (.*)$/i', $msg, $__)) {
                        yield $this->exec(function () use ($Autofor, $__, $chatID, $replyToId) {
                            if ($replyToId) {
                                if ($__[2] < 10) {
                                    $Text = '????????????: ?????? ???????? ?????? ???????? ?????????? ???? 10 ?????????? ????????.';
                                }
                                else {
                                    $time  = $__[2] * 60;
                                    $Array =
                                        [
                                            'Type' => [
                                                'supergroup',
                                                'user'
                                            ],
                                            'MsgId'        => $replyToId,
                                            'ChatId'       => $chatID,
                                            'sec'          => $time,
                                            'Time'         => time() + $time,
                                            'Successful'   => 0,
                                            'Unsuccessful' => 0,
                                        ];
                                    $Autofor['AutoFor'][] = $Array;
                                    yield put('Data/AutoFor/data.json', json_encode($Autofor, 448));
                                    $Text = "????????????????? ?????????????? ???????????????? ?????? ?????? ???????? ???????? $__[2] ?????????? ?????????? ????.";
                                }
                            }
                            else {
                                $Text = '??????????? ???? ?????? ?????? ?????? ???????????? ????????.';
                            }
                            yield $this->messages->sendMessage([
                                'peer'    => $chatID,
                                'message' => $Text,
                            ]);
                        });
                    }

                    if (preg_match('/^[#\!\/]?(AutoSend [+]) (.*)$/i', $msg, $__)) {
                        yield $this->exec(function () use ($Autofor, $__, $chatID, $replyToId) {
                            if ($replyToId) {
                                if ($__[2] < 10) {
                                    $Text = '????????????: ?????? ???????? ?????? ???????? ?????????? ???? 10 ?????????? ????????.';
                                }
                                else {
                                    $time  = $__[2] * 60;
                                    $Array =
                                        [
                                            'Type' => [
                                                'supergroup',
                                                'user'
                                            ],
                                            'MsgId'        => $replyToId,
                                            'ChatId'       => $chatID,
                                            'sec'          => $time,
                                            'Time'         => time() + $time,
                                            'Successful'   => 0,
                                            'Unsuccessful' => 0,
                                        ];
                                    $Autofor['AutoSend'][] = $Array;
                                    yield put('Data/AutoFor/data.json', json_encode($Autofor, 448));
                                    $Text = "????????????? ?????????????? ???????????????? ?????? ?????? ???????? ???????? $__[2] ?????????? ?????????? ????.";
                                }
                            }
                            else {
                                $Text = '??????????? ???? ?????? ?????? ?????? ???????????? ????????.';
                            }
                            yield $this->messages->sendMessage([
                                'peer'    => $chatID,
                                'message' => $Text
                            ]);
                        });
                    }

                    if (preg_match('/^[#\!\/]?(AutoFwd|AutoSend) (info)$/i', $msg, $__)) {
                        yield $this->exec(function () use ($chatID, $msg_id, $Autofor, $__) {
                            switch (strtolower($__[1])) {
                                case 'autofwd':
                                    if (!empty($Autofor['AutoFor'])) {
                                        foreach ($Autofor['AutoFor'] as $Number => $For) {
                                            $sent = yield $this->messages->forwardMessages([
                                                'from_peer' => $Autofor['AutoFor'][$Number]['ChatId'],
                                                'to_peer'   => $chatID,
                                                'id'        => [$Autofor['AutoFor'][$Number]['MsgId']],
                                            ]);
                                            $Text = '???? ?????? ?????????? : ' . ($Number + 1) . "\n" . '??? ?????????? ???????? : ' . $Autofor['AutoFor'][$Number]['Successful'] . "\n" . '??? ?????????? ???????????? : ' . $Autofor['AutoFor'][$Number]['Unsuccessful'] . "\n" . '??????????? ?????????? ?????? : ' . round($Autofor['AutoFor'][$Number]['sec'] / 60, 2) . ' ??????????' . "\n" . '?????? ?????? ?????????????? : ' . implode(',', $Autofor['AutoFor'][$Number]['Type']);
                                        }
                                    }
                                    else {
                                        $Text = '??????????? ???????? ???????? ?????????????? ?????????? ???????? ??????.';
                                    }
                                    yield $this->messages->sendMessage([
                                        'peer'            => $chatID,
                                        'reply_to_msg_id' => ($sent['id'] ?? $sent['updates'][0]['id'] ?? $msg_id),
                                        'message'         => $Text,
                                    ]);
                                    break;
                                case 'autosend':
                                    if (!empty($Autofor['AutoSend'])) {
                                        foreach ($Autofor['AutoSend'] as $Number => $For) {
                                            $sent = yield $this->messages->forwardMessages([
                                                'from_peer' => $Autofor['AutoSend'][$Number]['ChatId'],
                                                'to_peer'   => $chatID,
                                                'id'        => [$Autofor['AutoSend'][$Number]['MsgId']],
                                            ]);
                                            $Text = '???? ?????? ?????????? : ' . ($Number + 1) . "\n" . '??? ?????????? ???????? : ' . $Autofor['AutoSend'][$Number]['Successful'] . "\n" . '??? ?????????? ???????????? : ' . $Autofor['AutoSend'][$Number]['Unsuccessful'] . "\n" . '??????????? ?????????? ?????? : ' . round($Autofor['AutoSend'][$Number]['sec'] / 60, 2) . ' ??????????' . "\n" . '?????? ?????? ?????????? : ' . implode(',', $Autofor['AutoSend'][$Number]['Type']);
                                        }
                                    } else {
                                        $Text = '??????????? ???????? ???????? ?????????? ?????????? ???????? ??????.';
                                    }
                                    yield $this->messages->sendMessage([
                                        'peer'            => $chatID,
                                        'reply_to_msg_id' => ($sent['id'] ?? $sent['updates'][0]['id'] ?? $msg_id),
                                        'message'         => $Text,
                                    ]);
                                    break;
                            }
                        });
                    }

                    if (preg_match('/(AutoFwd|AutoSend) ((?>(?>Supergroup|user) \/ )?(?>Supergroup|user))$/si', strtolower($msg), $__)) {
                        yield $this->exec(function () use ($chatID, $msg_id, $Autofor, $__) {
                            switch ($__[1]) {
                                case 'autowd':
                                    $explode = explode(' / ', $__[2]);
                                    if (!empty($Autofor['AutoFor'])) {
                                        foreach ($Autofor['AutoFor'] as $Number => $For) {
                                            $Autofor['AutoFor'][$Number]['Type'] = $explode;
                                            yield put('Data/AutoFor/data.json', json_encode($Autofor, 448));
                                        }
                                        $Text = '??? ?????? ?????? ???? ?????? ???? ?????? ???? ???' . $__[2] . '??? ?????????????? ?????????? ????';
                                    }
                                    else {
                                        $Text = '??????????? ???????? ???????? ?????????????? ?????????? ???????? ??????.';
                                    }
                                    yield $this->messages->sendMessage([
                                        'peer'    => $chatID,
                                        'message' => $Text,
                                    ]);
                                    break;
                                case 'autosend':
                                    $explode = explode(' / ', $__[2]);
                                    if (!empty($Autofor['AutoSend'])) {
                                        foreach ($Autofor['AutoSend'] as $Number => $For) {
                                            $Autofor['AutoSend'][$Number]['Type'] = $explode;
                                            yield put('Data/AutoFor/data.json', json_encode($Autofor, 448));
                                        }
                                        $Text = '??? ?????? ?????? ???? ?????? ???? ?????? ???? ???' . $__[2] . '??? ?????????? ?????????? ????';
                                    }
                                    else {
                                        $Text = '??????????? ???????? ???????? ?????????? ?????????? ???????? ??????.';
                                    }
                                    yield $this->messages->sendMessage([
                                        'peer'    => $chatID,
                                        'message' => $Text,
                                    ]);
                                    break;
                            }
                        });
                    }

                    if (preg_match('/^[\/#!]?(AutoFwd|AutoSend) (clean)$/i', $msg, $__)) {
                        yield $this->exec(function () use ($chatID, $msg_id, $Autofor, $__) {
                            switch (strtolower($__[1])) {
                                case 'autofwd':
                                    if (!empty($Autofor['AutoFor'])) {
                                        foreach ($Autofor['AutoFor'] as $Number => $For) {
                                            unset($Autofor['AutoFor'][$Number]);
                                            yield put('Data/AutoFor/data.json', json_encode($Autofor, 448));
                                        }
                                        $Text = '???? ?????????? ?????? ?????? ?????????? ?????? ???????? ?????????????? ?????????????? ??????????';
                                    }
                                    else {
                                        $Text = '??????????? ???????? ???????? ?????????????? ?????????? ???????? ??????.';
                                    }
                                    yield $this->messages->sendMessage([
                                        'peer'    => $chatID,
                                        'message' => $Text,
                                    ]);
                                    break;
                                case 'autosend':
                                    if (!empty($Autofor['AutoSend'])) {
                                        foreach ($Autofor['AutoSend'] as $Number => $For) {
                                            unset($Autofor['AutoSend'][$Number]);
                                            yield put('Data/AutoFor/data.json', json_encode($Autofor, 448));
                                        }
                                        $Text = '???? ?????????? ?????? ?????? ?????????? ?????? ???????? ?????????? ?????????????? ??????????';
                                    }
                                    else {
                                        $Text = '??????????? ???????? ???????? ?????????? ?????????? ???????? ??????.';
                                    }
                                    yield $this->messages->sendMessage([
                                        'peer'    => $chatID,
                                        'message' => $Text,
                                    ]);
                                    break;
                            }
                        });
                    }

                    if (preg_match('/^[\/\#\!]?(del photos) ([1-9]+)$/i', $msg, $__)) {
                        yield $this->exec(function () use ($__, $chatID, $msg_id, $Me) {
                            $photos = yield $this->photos->getUserPhotos([
                                'user_id' => $Me['id'],
                                'offset'  => 0,
                                'max_id'  => 0,
                                'limit'   => $__[2]
                            ]);
                            $response      = yield $this->photos->deletePhotos([
                                'id' => $photos['photos']
                            ]);
                            yield $this->messages->sendMessage([
                                'peer'            => $chatID,
                                'reply_to_msg_id' => $msg_id,
                                'message'         => '???? ?????????? ' . count($response) . ' ?????? ???? ?????????????? ???? ???????????? ?????? ???? ???'
                            ]);
                        });
                    }

                    if (preg_match('/^[\/\#\!]?(del photo)$/i', $msg)) {
                        yield $this->exec(function () use ($chatID, $msg_id, $Me) {
                            $photos = yield $this->photos->getUserPhotos([
                                'user_id' => $Me['id'],
                                'offset'  => 0,
                                'max_id'  => 0,
                                'limit'   => 1
                            ]);
                            $response      = yield $this->photos->deletePhotos([
                                'id' => $photos['photos']
                            ]);
                            yield $this->messages->sendMessage([
                                'peer'            => $chatID,
                                'reply_to_msg_id' => $msg_id,
                                'message'         => '???? ?????????? ' . count($response) . ' ?????? ???? ?????????????? ???? ???????????? ?????? ???? ???'
                            ]);
                        });
                    }

                    if (preg_match('/^[\/#!]?(set photo)$/i', $msg) && isset($replyToId)) {
                        yield $this->exec(function () use ($chatID, $msg_id, $replyToId) {
                            $message = yield $this->getMessage($chatID, $replyToId);
                            if (isset($message['media']['photo'])) {
                                $media = $message['media']['photo'];
                                yield $this->photos->uploadProfilePhoto([
                                    'file' => $media
                                ]);
                                $text = '???? ???????????? ?????? ???????? ?????? ???? ?????????????? ???????? ?????????? ???? ???';
                            }
                            else {
                                $text = '?????? ?????? ?????? ?????????? ??????????????';
                            }
                            yield $this->messages->sendMessage([
                                'peer'            => $chatID,
                                'reply_to_msg_id' => $msg_id,
                                'message'         => $text
                            ]);
                        });
                    }

                    if (preg_match('/^[\/#!]?(fake user) (.*)$/i', $msg, $__)) {
                        yield $this->exec(function () use ($__, $chatID, $msg_id, $Me) {
                            $send = yield $this->messages->sendMessage([
                                'peer'            => $chatID,
                                'reply_to_msg_id' => $msg_id,
                                'message'         => '??? ???????? ???????????? ???????? ???????? ?????????? ????'
                            ]);
                            try {
                                $ph     = yield $this->photos->getUserPhotos([
                                    'user_id' => $Me['id'],
                                    'offset'  => 0,
                                    'max_id'  => 0,
                                    'limit'   => 80
                                ]);
                                $_iD    = $update['message']['entities'][0]['user_id'] ?? yield $this->getInfo($__[2])['bot_api_id'];
                                $info   = yield $this->getFullInfo($_iD);
                                $photos = yield $this->photos->getUserPhotos([
                                    'user_id' => $_iD,
                                    'offset'  => 0,
                                    'max_id'  => 0,
                                    'limit'   => 25
                                ]);
                                foreach (array_reverse($photos['photos']) as $photo) {
                                    yield $this->photos->uploadProfilePhoto([
                                        'file' => $photo
                                    ]);
                                    yield $this->sleep(2);
                                }
                                yield $this->account->updateProfile([
                                    'first_name' => $info['User']['first_name'],
                                    'last_name' => ($info['User']['last_name'] ?? ''),
                                    'about' => ($info['full']['about'] ?? '')
                                ]);
                                yield $this->photos->deletePhotos([
                                    'id' => $ph['photos']
                                ]);
                                $txt = "?????? ?????????? ??? <a href='tg://user?id=" . $_iD . "'>" . $info['User']['first_name'] . "</a> ??? ???? ???????????? ?????????? ???? ???";
                            } catch (Throwable $e) {
                                $txt = '?????????? ???????? ?????????????';
                            }
                            yield $this->messages->editMessage([
                                'peer'       => $chatID,
                                'id'         => $send['id'] ?? $send['updates'][0]['id'],
                                'message'    => $txt,
                                'parse_mode' => 'Html'
                            ]);
                        });
                    }

                    if (preg_match('/^[\/#!]?(Share)$/i', $msg)) {
                        yield $this->messages->sendMessage([
                            'peer'            => $chatID,
                            'reply_to_msg_id' => $msg_id,
                            'message'         => '???? ?????????? : +' . $Me['phone'] . "\n" . '???? ???????? : ' . $_SERVER['PHP_SELF'],
                            'parse_mode'      => 'html'
                        ]);
                    }

                    if (preg_match('/^[#!\/]?(AddAll SuperGroups) (.*)$/i', $msg, $__)) {
                        yield $this->exec(function () use ($__, $chatID, $msg_id) {
                            if (isset($__[2])) {
                                yield $this->messages->sendMessage([
                                    'peer'            => $chatID,
                                    'reply_to_msg_id' => $msg_id,
                                    'message'         => '??? ???????? ???????????? ???????? ???????? ?????????? ????',
                                    'parse_mode'      => 'html'
                                ]);
                                $_iD  = $update['message']['entities'][0]['user_id'] ?? yield $this->getInfo($__[2])['bot_api_id'];
                                $info = yield $this->getFullInfo($_iD);
                                $c    = 0;
                                foreach (yield $this->getDialogs() as $peer) {
                                    try {
                                        $type = yield $this->getInfo($peer);
                                        if ($type['type'] == 'supergroup') {
                                            yield $this->channels->inviteToChannel([
                                                'channel' => $peer,
                                                'users' => [$user]
                                            ]);
                                            $c++;
                                        }
                                    } catch (Exception $e) {}
                                }
                                yield $this->messages->editMessage([
                                    'peer'       => $chatID,
                                    'id'         => ($sent['id'] ?? $sent['updates'][0]['id'] ?? $msg_id),
                                    'message'    => "??? ?????????? ??? <a href='tg://user?id=" . $_iD . "'>" . $info['User']['first_name'] . "</a> ??? ???? ??? <code>" . $c . "</code> ??? ???????? ?????????? ????.",
                                    'parse_mode' => 'Html']);
                            }
                        });
                    }

                    if (preg_match('/^[\/#!]??(send) (all|pv|group)(.*?)$/si', $msg, $__) && empty($replyToId)) {
                        yield $this->exec(function () use ($__, $chatID, $msg_id) {
                            $ms   = microtime(true);
                            $sent = yield $this->messages->sendMessage([
                                'peer'            => $chatID,
                                'message'         => '??? ???????? ???????????? ???????? ???????? ?????????? ????',
                                'reply_to_msg_id' => $msg_id,
                                'parse_mode'      => 'Html'
                            ]);
                            switch (strtolower($__[2])) {
                                case 'all':
                                    $array = ['user', 'supergroup', 'chat'];
                                    break;
                                case 'group':
                                    $array = ['supergroup', 'chat'];
                                    break;
                                case 'pv':
                                    $array = ['user'];
                                    break;
                            }
                            $c          = ['Unsuccessful' => '0', 'Successful' => '0'];
                            $getDialogs = yield $this->getDialogs();
                            $count      = count($getDialogs);
                            foreach ($getDialogs as $Number => $peer) {
                                $type = yield $this->getInfo($peer);
                                if (in_array($type['type'], $array)) {
                                    try {
                                        yield $this->messages->sendMessage([
                                            'peer'          => $peer,
                                            'message'       => $__[3],
                                            'schedule_date' => time() + ($c['Successful'] * 5),
                                        ]);
                                        $c['Successful']++;
                                    } catch (Throwable $e) {
                                        $c['Unsuccessful']++;
                                    }
                                }
                                $action = str_replace(['all', 'group', 'pv'], ['??????', '????????', '????????'], strtolower($__[2]));
                                yield $this->messages->editMessage([
                                    'peer'    => $chatID,
                                    'message' => '???????? ?????? ???? ??? ' . $action . ' ??? ?????????? ?????????? ??????????' . "\n\n" . '??? ?????????? ???????? : ' . $c['Successful'] . "\n" . '??? ?????????? ???????????? : ' . $c['Unsuccessful'] . "\n" . '??? ?????? ???????? : ' . round((microtime(true) - $ms), 2) . ' ??????????' . "\n" . '???? ?????????? : ???? ?????? ?????????? ???????? ?????? ????????' . "\n\n" . progress('???', '???', $Number + 1, $count),
                                    'id'      => ($sent['id'] ?? $sent['updates'][0]['id'] ?? $msg_id),
                                ]);
                            }
                            yield $this->messages->editMessage([
                                'peer'    => $chatID,
                                'message' => '???????? ?????? ???? ??? ' . $action . ' ??? ?????????? ?????????? ??????????' . "\n\n" . '??? ?????????? ???????? : ' . $c['Successful'] . "\n" . '??? ?????????? ???????????? : ' . $c['Unsuccessful'] . "\n" . '??? ?????? ???????? : ' . round((microtime(true) - $ms), 2) . ' ??????????' . "\n" . '???? ?????????? : ?????????? ?????????? ?????? ??????' . "\n\n" . progress('???', '???', $Number + 1, $count),
                                'id'      => ($sent['id'] ?? $sent['updates'][0]['id'] ?? $msg_id),
                            ]);
                        });
                    }

                    if (preg_match('/^[\/#!]??(SendMedia) (all|pv|group)$/i', $msg, $__) && !empty($replyToId)) {
                        yield $this->exec(function () use ($__, $chatID, $msg_id, $update, $type, $replyToId) {
                            $ms   = microtime(true);
                            $sent = yield $this->messages->sendMessage([
                                'peer'            => $chatID,
                                'reply_to_msg_id' => $msg_id,
                                'message'         => '??? ???????? ???????????? ???????? ???????? ?????????? ????'
                            ]);
                            switch (strtolower($__[2])) {
                                case 'all':
                                    $array = ['user', 'supergroup', 'chat'];
                                    break;
                                case 'group':
                                    $array = ['supergroup', 'chat'];
                                    break;
                                case 'pv':
                                    $array = ['user'];
                                    break;
                            }
                            $c          = ['Unsuccessful' => '0', 'Successful' => '0'];
                            $getDialogs = yield $this->getDialogs();
                            $count      = count($getDialogs);
                            foreach ($getDialogs as $Number => $peer) {
                                try {
                                    $type = yield $this->getInfo($peer);
                                    if (in_array($type['type'], $array)) {
                                        yield $this->CopyMessage($chatID, $peer, $replyToId, time() + ($c['Successful'] * (rand(3, 6))));
                                        $c['Successful']++;
                                    }
                                } catch (Throwable $e) {
                                    $c['Unsuccessful']++;
                                }
                                $action = str_replace(['all', 'group', 'pv'], ['??????', '????????', '????????'], strtolower($__[2]));
                                yield $this->messages->editMessage([
                                    'peer'    => $chatID,
                                    'message' => '???????? ?????? ???? ??? ' . $action . ' ??? ?????????? ?????????? ??????????' . "\n\n" . '??? ?????????? ???????? : ' . $c['Successful'] . "\n" . '??? ?????????? ???????????? : ' . $c['Unsuccessful'] . "\n" . '??? ?????? ???????? : ' . round((microtime(true) - $ms), 2) . ' ??????????' . "\n" . '???? ?????????? : ???? ?????? ?????????? ???????? ?????? ????????' . "\n\n" . progress('???', '???', $Number + 1, $count),
                                    'id'      => ($sent['id'] ?? $sent['updates'][0]['id'] ?? $msg_id),
                                ]);
                            }
                            yield $this->messages->editMessage([
                                'peer'    => $chatID,
                                'message' => '???????? ?????? ???? ??? ' . $action . ' ??? ?????????? ?????????? ??????????' . "\n\n" . '??? ?????????? ???????? : ' . $c['Successful'] . "\n" . '??? ?????????? ???????????? : ' . $c['Unsuccessful'] . "\n" . '??? ?????? ???????? : ' . round((microtime(true) - $ms), 2) . ' ??????????' . "\n" . '???? ?????????? : ?????????? ?????????? ?????? ??????' . "\n\n" . progress('???', '???', $Number + 1, $count),
                                'id'      => ($sent['id'] ?? $sent['updates'][0]['id'] ?? $msg_id),
                            ]);
                        });
                    }

                    if (preg_match('/^[\/#!]?(forward) (all|pv|group)$/i', $msg, $__) && !empty($replyToId)) {
                        yield $this->exec(function () use ($__, $chatID, $msg_id, $update, $type) {
                            $ms   = microtime(true);
                            $sent = yield $this->messages->sendMessage([
                                'peer'            => $chatID,
                                'message'         => '??? ???????? ???????????? ???????? ???????? ?????????? ????',
                                'reply_to_msg_id' => $msg_id,
                                'parse_mode'      => 'Html'
                            ]);
                            if (isset($replyToId)) {
                                switch (strtolower($__[2])) {
                                    case 'all':
                                        $array = ['user',
                                            'supergroup',
                                            'chat'];
                                        break;
                                    case 'group':
                                        $array = ['supergroup',
                                            'chat'];
                                        break;
                                    case 'pv':
                                        $array = ['user'];
                                        break;
                                }
                                $c = ['Unsuccessful' => '0',
                                    'Successful' => '0'];
                                $getDialogs = yield $this->getDialogs();
                                $count      = count($getDialogs);
                                foreach ($getDialogs as $Number => $peer) {
                                    $type = yield $this->getInfo($peer);
                                    if (in_array($type['type'], $array)) {
                                        try {
                                            yield $this->messages->forwardMessages([
                                                'from_peer'     => $chatID,
                                                'to_peer'       => $peer,
                                                'id'            => [$replyToId],
                                                'schedule_date' => time() + ($c['Successful'] * 5),
                                            ]);
                                            $c['Successful']++;
                                        } catch (Throwable $e) {
                                            $c['Unsuccessful']++;
                                        }
                                    }
                                    $action = str_replace(['all', 'group', 'pv'], ['??????', '????????', '????????'], strtolower($__[2]));
                                    yield $this->messages->editMessage([
                                        'peer'    => $chatID,
                                        'message' => '???????? ?????? ???? ??? ' . $action . ' ??? ?????????????? ?????????? ??????????' . "\n\n" . '??? ?????????? ???????? : ' . $c['Successful'] . "\n" . '??? ?????????? ???????????? : ' . $c['Unsuccessful'] . "\n" . '??? ?????? ???????? : ' . round((microtime(true) - $ms), 2) . ' ??????????' . "\n" . '???? ?????????? : ???? ?????? ?????????? ???????? ?????? ????????' . "\n\n" . progress('???', '???', $Number + 1, $count),
                                        'id'      => ($sent['id'] ?? $sent['updates'][0]['id'] ?? $msg_id),
                                    ]);
                                }
                                yield $this->messages->editMessage([
                                    'peer'    => $chatID,
                                    'message' => '???????? ?????? ???? ??? ' . $action . ' ??? ?????????????? ?????????? ??????????' . "\n\n" . '??? ?????????? ???????? : ' . $c['Successful'] . "\n" . '??? ?????????? ???????????? : ' . $c['Unsuccessful'] . "\n" . '??? ?????? ???????? : ' . round((microtime(true) - $ms), 2) . ' ??????????' . "\n" . '???? ?????????? : ?????????? ?????????? ?????? ??????' . "\n\n" . progress('???', '???', $Number + 1, $count),
                                    'id'      => ($sent['id'] ?? $sent['updates'][0]['id'] ?? $msg_id),
                                ]);
                            }
                        });
                    }

                    if (preg_match('/^(Leave Deleted)$/i', $msg)) {
                        yield $this->exec(function () use ($chatID, $msg_id) {
                            $ms         = microtime(true);
                            $sent       = yield $this->messages->sendMessage([
                                'peer'    => $chatID,
                                'message' => '??? ???????? ???????????? ???????? ???????? ?????????? ????'
                            ]);
                            $c          = ['Unsuccessful' => '0', 'Successful' => '0'];
                            $getDialogs = yield $this->getDialogs();
                            $count      = count($getDialogs);
                            foreach ($getDialogs as $Number => $peer) {
                                try {
                                    switch ($peer['_'] ?? '') {
                                        case 'peerUser':
                                            if ((yield $this->getFullinfo($peer))['User']['deleted'] == true) {
                                                yield $this->messages->deleteHistory([
                                                    'just_clear'  => false,
                                                    'revoke'      => true,
                                                    'peer'        => $peer,
                                                    'max_id'      => 0
                                                ]);
                                                $c['Successful']++;
                                            }
                                            break;
                                    }
                                } catch (Throwable $e) {
                                    $c['Unsuccessful']++;
                                }
                                yield $this->messages->editMessage([
                                    'peer' => $chatID,
                                    'message' => '???? ?????? ?????????????? ?? ?????? ?????? ???????? ?????????? ?????? ???????? ???????? ?????????? ??????' . "\n\n" . '??? ?????????? ???????? : ' . $c['Successful'] . "\n" . '??? ?????????? ???????????? : ' . $c['Unsuccessful'] . "\n" . '??? ?????? ????????: ' . round((microtime(true) - $ms), 2) . ' ??????????' . "\n" . '???? ?????????? : ???? ?????? ?????????? ???????? ?????? ????????' . "\n\n" . progress('???', '???', $Number + 1, $count),
                                    'id' => ($sent['id'] ?? $sent['updates'][0]['id'] ?? $msg_id),
                                ]);
                            }
                            yield $this->messages->editMessage([
                                'peer'    => $chatID,
                                'message' => '???? ?????? ?????????????? ?? ?????? ?????? ???????? ?????????? ?????? ???????? ???????? ?????????? ??????' . "\n\n" . '??? ?????????? ???????? : ' . $c['Successful'] . "\n" . '??? ?????????? ???????????? : ' . $c['Unsuccessful'] . "\n" . '??? ?????? ????????: ' . round((microtime(true) - $ms), 2) . ' ??????????' . "\n" . '???? ?????????? : ?????????? ?????????? ?????? ??????' . "\n\n" . progress('???', '???', $Number + 1, $count),
                                'id'      => ($sent['id'] ?? $sent['updates'][0]['id'] ?? $msg_id),
                            ]);
                        });
                    }

                    if (preg_match('/^[\/\#\!]?(Leave Supergroups) ([0-9]{1,3})$/i', strtolower($msg), $__)) {
                        yield $this->exec(function () use ($__, $chatID, $msg_id) {
                            $ms         = microtime(true);
                            $sent       = yield $this->messages->sendMessage([
                                'peer'            => $chatID,
                                'reply_to_msg_id' => $msg_id,
                                'message'         => '??? ???????? ???????????? ???????? ???????? ?????????? ????'
                            ]);
                            $c          = ['Unsuccessful' => '0', 'Successful' => '0'];
                            $getDialogs = yield $this->getDialogs();
                            $count      = count($getDialogs);
                            foreach ($getDialogs as $Number => $peer) {
                                try {
                                    $type = yield $this->getInfo($peer);
                                    if ($type['type'] == 'supergroup' or $type['type'] == 'chat') {
                                        if (isset($type['bot_api_id'])) {
                                            yield $this->channels->leaveChannel([
                                                'channel' => $peer
                                            ]);
                                            $c['Successful']++;
                                            if ($c['Successful'] == $__[2]) {
                                                break;
                                            }
                                        }
                                    }
                                } catch (Throwable $e) {
                                    $c['Unsuccessful']++;
                                }
                                yield $this->messages->editMessage([
                                    'peer'    => $chatID,
                                    'message' => '???? ?????? ?????????????? ?? ???????? ?????? ???????? ???? ???????? ???????? ?????????? ??????' . "\n\n" . '??? ?????????? ???????? : ' . $c['Successful'] . "\n" . '??? ?????????? ???????????? : ' . $c['Unsuccessful'] . "\n" . '??? ?????? ????????: ' . round((microtime(true) - $ms), 2) . ' ??????????' . "\n" . '???? ?????????? : ???? ?????? ?????????? ???????? ?????? ????????' . "\n\n" . progress('???', '???', $Number + 1, $count),
                                    'id'      => ($sent['id'] ?? $sent['updates'][0]['id'] ?? $msg_id),
                                ]);
                            }
                            yield $this->messages->editMessage([
                                'peer'    => $chatID,
                                'message' => '???? ?????? ?????????????? ?? ???????? ?????? ???????? ???? ???????? ???????? ?????????? ??????' . "\n\n" . '??? ?????????? ???????? : ' . $c['Successful'] . "\n" . '??? ?????????? ???????????? : ' . $c['Unsuccessful'] . "\n" . '??? ?????? ????????: ' . round((microtime(true) - $ms), 2) . ' ??????????' . "\n" . '???? ?????????? : ?????????? ?????????? ?????? ??????' . "\n\n" . progress('???', '???', $Number + 1, $count),
                                'id'      => ($sent['id'] ?? $sent['updates'][0]['id'] ?? $msg_id),
                            ]);
                        });
                    }

                    if (preg_match('/^[\/#!]?(Leave Channels)$/i', $msg)) {
                        yield $this->exec(function () use ($chatID, $msg_id) {
                            $ms         = microtime(true);
                            $sent       = yield $this->messages->sendMessage([
                                'peer'            => $chatID,
                                'reply_to_msg_id' => $msg_id,
                                'message'         => '??? ???????? ???????????? ???????? ???????? ?????????? ????'
                            ]);
                            $c          = ['Unsuccessful' => '0', 'Successful' => '0'];
                            $getDialogs = yield $this->getDialogs();
                            $count      = count($getDialogs);
                            foreach ($getDialogs as $Number => $peer) {
                                try {
                                    $type = yield $this->getInfo($peer);
                                    if ($type['type'] == 'channel') {
                                        if (isset($type['bot_api_id'])) {
                                            yield $this->channels->leaveChannel([
                                                'channel' => $peer
                                            ]);
                                            $c['Successful']++;
                                        }
                                    }
                                } catch (Throwable $e) {
                                    $c['Unsuccessful']++;
                                }
                                yield $this->messages->editMessage([
                                    'peer'    => $chatID,
                                    'message' => '???? ?????? ?????????????? ?? ???????? ?????? ?????????? ???? ???????? ???????? ?????????? ??????' . "\n\n" . '??? ?????????? ???????? : ' . $c['Successful'] . "\n" . '??? ?????????? ???????????? : ' . $c['Unsuccessful'] . "\n" . '??? ?????? ????????: ' . round((microtime(true) - $ms), 2) . ' ??????????' . "\n" . '???? ?????????? : ???? ?????? ?????????? ???????? ?????? ????????' . "\n\n" . progress('???', '???', $Number + 1, $count),
                                    'id'      => ($sent['id'] ?? $sent['updates'][0]['id'] ?? $msg_id),
                                ]);
                            }
                            yield $this->messages->editMessage([
                                'peer'    => $chatID,
                                'message' => '???? ?????? ?????????????? ?? ???????? ?????? ?????????? ???? ???????? ???????? ?????????? ??????' . "\n\n" . '??? ?????????? ???????? : ' . $c['Successful'] . "\n" . '??? ?????????? ???????????? : ' . $c['Unsuccessful'] . "\n" . '??? ?????? ????????: ' . round((microtime(true) - $ms), 2) . ' ??????????' . "\n" . '???? ?????????? : ?????????? ?????????? ?????? ??????' . "\n\n" . progress('???', '???', $Number + 1, $count),
                                'id'      => ($sent['id'] ?? $sent['updates'][0]['id'] ?? $msg_id),
                            ]);
                        });
                    }

                    if (preg_match('/^[\/#!]?(Leave Limit)$/i', $msg)) {
                        yield $this->exec(function () use ($chatID, $msg_id) {
                            $ms         = microtime(true);
                            $sent       = yield $this->messages->sendMessage([
                                'peer'            => $chatID,
                                'reply_to_msg_id' => $msg_id,
                                'message'         => '??? ???????? ???????????? ???????? ???????? ?????????? ????'
                            ]);
                            $c          = ['Unsuccessful' => '0', 'Successful' => '0'];
                            $getDialogs = yield $this->getDialogs();
                            $count      = count($getDialogs);
                            foreach ($getDialogs as $Number => $peer) {
                                try {
                                    $type = yield $this->getInfo($peer);
                                    if ($type['type'] == 'supergroup' or $type['type'] == 'chat' or $type['type'] == 'chat') {
                                        if (isset($type['Chat']['banned_rights']) and $type['Chat']['banned_rights']['send_messages'] == true) {
                                            yield $this->channels->leaveChannel([
                                                'channel' => $peer
                                            ]);
                                            $c['Successful']++;
                                        }
                                    }
                                } catch (Throwable $e) {
                                    $c['Unsuccessful']++;
                                }
                                yield $this->messages->editMessage([
                                    'peer'    => $chatID,
                                    'message' => '???? ?????? ?????????????? ?? ???????? ?????? ???????? ?????? ?????????? ?????? ???????? ???????? ?????????? ??????' . "\n\n" . '??? ?????????? ???????? : ' . $c['Successful'] . "\n" . '??? ?????????? ???????????? : ' . $c['Unsuccessful'] . "\n" . '??? ?????? ????????: ' . round((microtime(true) - $ms), 2) . ' ??????????' . "\n" . '???? ?????????? : ???? ?????? ?????????? ???????? ?????? ????????' . "\n\n" . progress('???', '???', $Number + 1, $count),
                                    'id'      => ($sent['id'] ?? $sent['updates'][0]['id'] ?? $msg_id),
                                ]);
                            }
                            yield $this->messages->editMessage([
                                'peer'    => $chatID,
                                'message' => '???? ?????? ?????????????? ?? ???????? ?????? ???????? ?????? ?????????? ?????? ???????? ???????? ?????????? ??????' . "\n\n" . '??? ?????????? ???????? : ' . $c['Successful'] . "\n" . '??? ?????????? ???????????? : ' . $c['Unsuccessful'] . "\n" . '??? ?????? ????????: ' . round((microtime(true) - $ms), 2) . ' ??????????' . "\n" . '???? ?????????? : ?????????? ?????????? ?????? ??????' . "\n\n" . progress('???', '???', $Number + 1, $count),
                                'id'      => ($sent['id'] ?? $sent['updates'][0]['id'] ?? $msg_id),
                            ]);
                        });
                    }

                    if (preg_match('/^(Leave Users)$/i', $msg)) {
                        yield $this->exec(function () use ($chatID, $msg_id) {
                            $ms         = microtime(true);
                            $sent       = yield $this->messages->sendMessage([
                                'peer'            => $chatID,
                                'reply_to_msg_id' => $msg_id,
                                'message'         => '??? ???????? ???????????? ???????? ???????? ?????????? ????'
                            ]);
                            $c          = ['Unsuccessful' => '0', 'Successful' => '0'];
                            $getDialogs = yield $this->getDialogs();
                            $count      = count($getDialogs);
                            foreach ($getDialogs as $Number => $peer) {
                                try {
                                    switch ($peer['_'] ?? '') {
                                        case 'peerUser':
                                            yield $this->messages->deleteHistory([
                                                'just_clear' => false,
                                                'revoke'     => true,
                                                'peer'       => $peer,
                                                'max_id'     => 0
                                            ]);
                                            $c['Successful']++;
                                            break;
                                    }
                                } catch (Throwable $e) {
                                    $c['Unsuccessful']++;
                                }
                                yield $this->messages->editMessage([
                                    'peer'    => $chatID,
                                    'message' => '???? ?????? ?????????????? ?? ?????? ?????? ???????? ???? ???????? ???????? ?????????? ??????' . "\n\n" . '??? ?????????? ???????? : ' . $c['Successful'] . "\n" . '??? ?????????? ???????????? : ' . $c['Unsuccessful'] . "\n" . '??? ?????? ????????: ' . round((microtime(true) - $ms), 2) . ' ??????????' . "\n" . '???? ?????????? : ???? ?????? ?????????? ???????? ?????? ????????' . "\n\n" . progress('???', '???', $Number + 1, $count),
                                    'id'      => ($sent['id'] ?? $sent['updates'][0]['id'] ?? $msg_id),
                                ]);
                            }
                            yield $this->messages->editMessage([
                                'peer'    => $chatID,
                                'message' => '???? ?????? ?????????????? ?? ?????? ?????? ???????? ???? ???????? ???????? ?????????? ??????' . "\n\n" . '??? ?????????? ???????? : ' . $c['Successful'] . "\n" . '??? ?????????? ???????????? : ' . $c['Unsuccessful'] . "\n" . '??? ?????? ????????: ' . round((microtime(true) - $ms), 2) . ' ??????????' . "\n" . '???? ?????????? : ?????????? ?????????? ?????? ??????' . "\n\n" . progress('???', '???', $Number + 1, $count),
                                'id'      => ($sent['id'] ?? $sent['updates'][0]['id'] ?? $msg_id),
                            ]);
                        });
                    }

                    if (preg_match('/^(reset)$/i', $msg)) {
                        yield $this->exec(function () use ($chatID, $msg_id) {
                            $ms   = microtime(true);
                            $sent = yield $this->messages->sendMessage([
                                'peer'    => $chatID,
                                'message' => '??? ???????? ???????????? ???????? ???????? ?????????? ????',
                            ]);
                            $c          = ['Unsuccessful' => '0', 'Successful' => '0'];
                            $getDialogs = yield $this->getDialogs();
                            $count      = count($getDialogs);
                            foreach ($getDialogs as $Number => $Dia) {
                                try {
                                    $type = yield $this->getInfo($Dia);
                                    if ($type['type'] == 'supergroup' or $type['type'] == 'chat' or $type['type'] == 'chat') {
                                        if (isset($type['Chat']['banned_rights']) and $type['Chat']['banned_rights']['send_messages'] == true) {
                                            yield $this->channels->leaveChannel([
                                                'channel' => $Dia
                                            ]);
                                            $c['Successful']++;
                                        }
                                    }
                                } catch (Throwable $e) {
                                    $c['Unsuccessful']++;
                                }
                                switch ($Dia['_'] ?? '') {
                                    case 'peerUser':
                                        try {
                                            if ((yield $this->getFullinfo($Dia))['User']['deleted'] == true) {
                                                yield $this->messages->deleteHistory([
                                                    'just_clear' => false,
                                                    'revoke'     => true,
                                                    'peer'       => $Dia,
                                                    'max_id'     => 0
                                                ]);
                                                $c['Successful']++;
                                            }
                                            break;
                                        } catch (Throwable $e) {
                                            $c['Unsuccessful']++;
                                        }
                                }
                                yield $this->messages->editMessage([
                                    'peer'    => $chatID,
                                    'message' => '??? ???? ?????? ?????????? ???????????? ???????? ???????? ?????????? ??????' . "\n\n" . '??? ?????????? ???????? : ' . $c['Successful'] . "\n" . '??? ?????????? ???????????? : ' . $c['Unsuccessful'] . "\n" . '??? ?????? ????????: ' . round((microtime(true) - $ms), 2) . ' ??????????' . "\n" . '???? ?????????? : ???? ?????? ?????????? ???????? ?????? ????????' . "\n\n" . progress('???', '???', $Number + 1, $count),
                                    'id'      => ($sent['id'] ?? $sent['updates'][0]['id'] ?? $msg_id),
                                ]);
                            }
                            yield $this->messages->editMessage([
                                'peer'    => $chatID,
                                'message' => '??? ???? ?????? ?????????? ???????????? ???????? ???????? ?????????? ??????' . "\n\n" . '??? ?????????? ???????? : ' . $c['Successful'] . "\n" . '??? ?????????? ???????????? : ' . $c['Unsuccessful'] . "\n" . '??? ?????? ????????: ' . round((microtime(true) - $ms), 2) . ' ??????????' . "\n" . '???? ?????????? : ?????????? ?????????? ?????? ??????' . "\n\n" . progress('???', '???', $Number + 1, $count),
                                'id'      => ($sent['id'] ?? $sent['updates'][0]['id'] ?? $msg_id),
                            ]);
                        });
                    }

                    if (preg_match('/^(Addmembers) (.*) (.*)$/i', $msg, $__)) {
                        yield $this->exec(function () use ($chatID, $msg_id, $__) {
                            $ms         = microtime(true);
                            $sent       = yield $this->messages->sendMessage([
                                'peer'             => $chatID,
                                'message'          => '??? ???????? ???????????? ???????? ???????? ?????????? ????',
                                'reply_to_msg_id'  => $msg_id,
                                'parse_mode'       => 'markdown'
                            ]);
                            $c          = ['Unsuccessful' => '0', 'Successful' => '0'];
                            $getDialogs = yield $this->getDialogs();
                            $count      = count($getDialogs);
                            foreach ($getDialogs as $Number => $peer) {
                                if ($c['Successful'] === $__[3]) {
                                    break;
                                }
                                $type = yield $this->getInfo($peer);
                                if ($type['type'] == 'user') {
                                    try {
                                        yield $this->channels->inviteToChannel([
                                            'channel' => $__[2],
                                            'users'   => [$type['user_id']]
                                        ]);
                                        $c['Successful']++;
                                    } catch (Throwable $e) {
                                        $c['Unsuccessful']++;
                                    }
                                }
                                yield $this->messages->editMessage([
                                    'peer'    => $chatID,
                                    'message' => '???? ?????? ?????????? ???????? ?????? ???? ???????? ???????? ???????? ?????????? ??????' . "\n\n" . '??? ?????????? ???????? : ' . $c['Successful'] . "\n" . '??? ?????????? ???????????? : ' . $c['Unsuccessful'] . "\n" . '??? ?????? ????????: ' . round((microtime(true) - $ms), 2) . ' ??????????' . "\n" . '???? ?????????? : ???? ?????? ?????????? ???????? ?????? ????????' . "\n\n" . progress('???', '???', $Number + 1, $count),
                                    'id'      => ($sent['id'] ?? $sent['updates'][0]['id'] ?? $msg_id),
                                ]);
                            }
                            yield $this->messages->editMessage([
                                'peer'    => $chatID,
                                'message' => '???? ?????? ?????????? ???????? ?????? ???? ???????? ???????? ???????? ?????????? ??????' . "\n\n" . '??? ?????????? ???????? : ' . $c['Successful'] . "\n" . '??? ?????????? ???????????? : ' . $c['Unsuccessful'] . "\n" . '??? ?????? ????????: ' . round((microtime(true) - $ms), 2) . ' ??????????' . "\n" . '???? ?????????? : ?????????? ?????????? ?????? ??????' . "\n\n" . progress('???', '???', $Number + 1, $count),
                                'id'      => ($sent['id'] ?? $sent['updates'][0]['id'] ?? $msg_id),
                            ]);
                        });
                    }

                    if (strpos($msg, 'AddmembersAll ') !== false) {
                        yield $this->exec(function () use ($chatID, $msg_id, $msg) {
                            $ms   = microtime(true);
                            $sent = yield $this->messages->sendMessage([
                                'peer'            => $chatID,
                                'message'         => '??? ???????? ???????????? ???????? ???????? ?????????? ????',
                                'reply_to_msg_id' => $msg_id,
                                'parse_mode'      => 'markdown'
                            ]);
                            $gpid       = explode('AddmembersAll ', $msg)[1];
                            $c          = ['Unsuccessful' => '0', 'Successful' => '0'];
                            $getDialogs = yield $this->getDialogs();
                            $count      = count($getDialogs);
                            foreach ($getDialogs as $Number => $peer) {
                                $type = yield $this->getInfo($peer);
                                if ($type['type'] == 'user') {
                                    $ID[] = $type['user_id'];
                                }
                            }
                            foreach (array_chunk($ID, 50) as $PVID) {
                                try {
                                    yield $this->channels->inviteToChannel([
                                        'channel' => $gpid,
                                        'users'   => $PVID
                                    ]);
                                    $c['Successful']++;
                                } catch (Throwable $e) {
                                    $c['Unsuccessful']++;
                                }
                                yield $this->messages->editMessage([
                                    'peer'    => $chatID,
                                    'message' => '???? ?????? ?????????? ???????? ?????? ???? ???????? ???????? ???????? ?????????? ??????' . "\n\n" . '??? ?????????? ???????? : ' . $c['Successful'] . "\n" . '??? ?????????? ???????????? : ' . $c['Unsuccessful'] . "\n" . '??? ?????? ????????: ' . round((microtime(true) - $ms), 2) . ' ??????????' . "\n" . '???? ?????????? : ???? ?????? ?????????? ???????? ?????? ????????' . "\n\n" . progress('???', '???', $Number + 1, $count),
                                    'id'      => ($sent['id'] ?? $sent['updates'][0]['id'] ?? $msg_id),
                                ]);
                            }
                            yield $this->messages->editMessage([
                                'peer'    => $chatID,
                                'message' => '???? ?????? ?????????? ???????? ?????? ???? ???????? ???????? ???????? ?????????? ??????' . "\n\n" . '??? ?????????? ???????? : ' . $c['Successful'] . "\n" . '??? ?????????? ???????????? : ' . $c['Unsuccessful'] . "\n" . '??? ?????? ????????: ' . round((microtime(true) - $ms), 2) . ' ??????????' . "\n" . '???? ?????????? : ?????????? ?????????? ?????? ??????' . "\n\n" . progress('???', '???', $Number + 1, $count),
                                'id'      => ($sent['id'] ?? $sent['updates'][0]['id'] ?? $msg_id),
                            ]);
                        });
                    }

                    if (preg_match("/^(AddContacts) (.*) (.*)$/i", $msg, $__)) {
                        yield $this->exec(function () use ($chatID, $msg_id, $__) {
                            $ms            = microtime(true);
                            $sent = yield $this->messages->sendMessage([
                                'peer'            => $chatID,
                                'message'         => '??? ???????? ???????????? ???????? ???????? ?????????? ????',
                                'reply_to_msg_id' => $msg_id,
                                'parse_mode'      => 'markdown'
                            ]);
                            $c             = ['Unsuccessful' => '0', 'Successful' => '0'];
                            $getContactIDs = yield $this->contacts->getContactIDs();
                            $count         = count($getContactIDs);
                            foreach ($getContactIDs as $Number => $user) {
                                try {
                                    yield $this->channels->inviteToChannel([
                                        'channel' => $__[2],
                                        'users'   => [$user]
                                    ]);
                                    $c['Successful']++;
                                } catch (Throwable $e) {
                                    $c['Unsuccessful']++;
                                }
                                yield $this->messages->editMessage([
                                    'peer'    => $chatID,
                                    'message' => '???? ?????? ?????????? ???????? ?????? ???? ???????? ???????? ???????? ?????????? ??????' . "\n\n" . '??? ?????????? ???????? : ' . $c['Successful'] . "\n" . '??? ?????????? ???????????? : ' . $c['Unsuccessful'] . "\n" . '??? ?????? ????????: ' . round((microtime(true) - $ms), 2) . ' ??????????' . "\n" . '???? ?????????? : ???? ?????? ?????????? ???????? ?????? ????????' . "\n\n" . progress('???', '???', $Number + 1, $count),
                                    'id'      => ($sent['id'] ?? $sent['updates'][0]['id'] ?? $msg_id),
                                ]);
                            }
                            yield $this->messages->editMessage([
                                'peer'    => $chatID,
                                'message' => '???? ?????? ?????????? ???????? ?????? ???? ???????? ???????? ???????? ?????????? ??????' . "\n\n" . '??? ?????????? ???????? : ' . $c['Successful'] . "\n" . '??? ?????????? ???????????? : ' . $c['Unsuccessful'] . "\n" . '??? ?????? ????????: ' . round((microtime(true) - $ms), 2) . ' ??????????' . "\n" . '???? ?????????? : ?????????? ?????????? ?????? ??????' . "\n\n" . progress('???', '???', $Number + 1, $count),
                                'id'      => ($sent['id'] ?? $sent['updates'][0]['id'] ?? $msg_id),
                            ]);
                        });
                    }

                    if (strpos($msg, 'AddContactsAll ') !== false) {
                        yield $this->exec(function () use ($chatID, $msg_id, $msg) {
                            $ms            = microtime(true);
                            $sent = yield $this->messages->sendMessage([
                                'peer'            => $chatID,
                                'message'         => '??? ???????? ???????????? ???????? ???????? ?????????? ????',
                                'reply_to_msg_id' => $msg_id,
                                'parse_mode'      => 'markdown'
                            ]);
                            $gpid          = explode('AddContactsAll ', $msg)[1];
                            $c             = ['Unsuccessful' => '0', 'Successful' => '0'];
                            $getContactIDs = yield $this->contacts->getContactIDs();
                            $count         = count($getContactIDs);
                            foreach ($getContactIDs as $Number => $user) {
                                if ($c['Successful'] === $__[3]) {
                                    break;
                                }
                                try {
                                    yield $this->channels->inviteToChannel([
                                        'channel' => $gpid,
                                        'users'   => [$user]
                                    ]);
                                    $c['Successful']++;
                                } catch (Throwable $e) {
                                    $c['Unsuccessful']++;
                                }
                                yield $this->messages->editMessage([
                                    'peer'    => $chatID,
                                    'message' => '???? ?????? ?????????? ???????? ?????? ???? ???????? ???????? ???????? ?????????? ??????' . "\n\n" . '??? ?????????? ???????? : ' . $c['Successful'] . "\n" . '??? ?????????? ???????????? : ' . $c['Unsuccessful'] . "\n" . '??? ?????? ????????: ' . round((microtime(true) - $ms), 2) . ' ??????????' . "\n" . '???? ?????????? : ???? ?????? ?????????? ???????? ?????? ????????' . "\n\n" . progress('???', '???', $Number + 1, $count),
                                    'id'      => ($sent['id'] ?? $sent['updates'][0]['id'] ?? $msg_id),
                                ]);
                            }
                            yield $this->messages->editMessage([
                                'peer'    => $chatID,
                                'message' => '???? ?????? ?????????? ???????? ?????? ???? ???????? ???????? ???????? ?????????? ??????' . "\n\n" . '??? ?????????? ???????? : ' . $c['Successful'] . "\n" . '??? ?????????? ???????????? : ' . $c['Unsuccessful'] . "\n" . '??? ?????? ????????: ' . round((microtime(true) - $ms), 2) . ' ??????????' . "\n" . '???? ?????????? : ?????????? ?????????? ?????? ??????' . "\n\n" . progress('???', '???', $Number + 1, $count),
                                'id'      => ($sent['id'] ?? $sent['updates'][0]['id'] ?? $msg_id),
                            ]);
                        });
                    }

                    if (preg_match('/^[\/#!]?(reload|????????)$/i', $msg)) {
                        yield $this->messages->sendMessage([
                            'peer'            => $chatID,
                            'reply_to_msg_id' => $msg_id,
                            'message'         => "???? ?????????? ???? ???????????? ?????????????? ????\n??? ???????????? ?????? ???????? ???? ???????? ????????????????????? ??????.",
                            'parse_mode'      => 'html'
                        ]);
                        //shell_exec('resapp ' . __DIR__ . ' &');
                        $this->restart();
                    }

                    if (preg_match('/^[\/#!]?(ping|????????|????????)$/i', $msg)) {
                        yield $this->messages->sendMessage([
                            'peer'            => $chatID,
                            'message'         => "[?????????????????????????????????\n?????????????????????????????????\n?????????????????????????????????????????????\n?????????????????????????????????????????????\n?????????????????????????????????????????????\n?????????????????????????????????????????????](tg://user?id=$userID)",
                            'reply_to_msg_id' => $msg_id,
                            'parse_mode'      => 'markdown'
                        ]);
                    }

                    if (preg_match('/^[\/#!]?(Online|????????????|????????????)$/i', $msg)) {
                        yield $this->messages->forwardMessages([
                            'from_peer' => $chatID,
                            'to_peer'   => $chatID,
                            'id'        => [$msg_id]
                        ]);
                    }

                    if (preg_match('/^[\/#!]?(listlink)$/i', $msg)) {
                        yield $this->exec(function () use ($chatID, $msg_id, $Link) {
                            if (count($Link['Link']['Link']) > 5) {
                                $countlink = count($Link['Link']['Link']) ?? 0;
                                yield $this->messages->sendMedia([
                                    'peer'            => $chatID,
                                    'reply_to_msg_id' => $msg_id,
                                    'media'           => [
                                        '_'           => 'inputMediaUploadedDocument',
                                        'file'        => 'Data/link.json',
                                        'attributes'  => [
                                            [
                                                '_'         => 'documentAttributeFilename',
                                                'file_name' => 'List-Link'
                                            ]
                                        ]
                                    ],
                                    'message'    => "???  ?????????????? ???????????????? ?????????? ???????????? ??????????.\n???  ?????????????????? ?????????????? ?????????? ?????????? ??????????: **$countlink**",
                                    'parse_mode' => 'MarkDown'
                                ]);
                            } else {
                                yield $this->messages->sendMessage([
                                    'peer'            => $chatID,
                                    'message'         => ' ?????????? ???????? ???? ???????? ?????????? ???????? ?????? ?????????? ??????',
                                    'reply_to_msg_id' => $msg_id
                                ]);
                            }
                        });
                    }

                    if (preg_match('/^[\/#!]?(resetlinks)$/i', $msg)) {
                        yield $this->exec(function () use ($chatID, $msg_id, $Link) {
                            if (count($Link['Link']['Link']) > 0) {
                                $Link['Link']['Link'] = [];
                                $Link['joinshod']     = 0;
                                $Link['expired']      = 0;
                                yield put('Data/link.json', json_encode($Link));
                                $Text = '???????????????? ?????????? ?????? ?????????????? ?????? ???';
                            } else {
                                $Text = '???????? ?????????????? ???????? ?????? ??????';
                            }
                            yield $this->messages->sendMessage([
                                'peer'            => $chatID,
                                'message'         => $Text,
                                'reply_to_msg_id' => $msg_id
                            ]);
                        });
                    }

                    if (preg_match('/^[\/#!]?(joinlinkdoni)$/i', $msg)) {
                        yield $this->exec(function () use ($chatID, $msg_id) {
                            $linkdonilist = array("grouhkadeh", "linkdoni", "linkdoni_co", "linkdoni1", "Linkdoni_kade", "gorohkadetel", "goroh_linky", "linkdoniiiii5", "Link4you", "linkdonifori");
                            foreach ($linkdonilist as $list) {
                                try {
                                    yield $this->channels->joinChannel([
                                        'channel' => "https://t.me/$list"
                                    ]);
                                } catch (Throwable $e) {
                                }
                            }
                            yield $this->messages->sendMessage([
                                'peer'            => $chatID,
                                'reply_to_msg_id' => $msg_id,
                                'message'         => '??? ???????? ???? ???????????? ???? #????????????????_???? ???????? ???? ???'
                            ]);
                        });
                    }
                    switch (strtolower($msg)) {
                        case '??????'  :
                        case 'panel':
                            yield $this->exec(function () use ($chatID) {
                                $messages_BotResults = yield $this->messages->getInlineBotResults([
                                    'bot'    => "@TabCiBot",
                                    'peer'   => $chatID,
                                    'query'  => "panel_",
                                    'offset' => '0'
                                ]);
                                $query_id            = $messages_BotResults['query_id'];
                                $query_res_id        = $messages_BotResults['results'][0]['id'];
                                yield $this->messages->sendInlineBotResult([
                                    'silent'      => true,
                                    'background'  => false,
                                    'clear_draft' => true,
                                    'peer'        => $chatID,
                                    'query_id'    => $query_id,
                                    'id'          => $query_res_id
                                ]);
                            });
                            break;
                        /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
                        case '???????? ????' :
                        case 'sessions':
                            yield $this->exec(function () use ($chatID) {
                                $authorizations = yield $this->account->getAuthorizations();
                                $_              = "A???? S???ss??????? ???? ???????? ???????????????????? :" . PHP_EOL . PHP_EOL;
                                foreach ($authorizations['authorizations'] as $authorization) {
                                    $_ .= "H???s?? ??? ??? " . $authorization['hash'] . " ???\nD?????????????? ?????????????? ??? ??? " . $authorization['device_model'] . " ???\nS??s????????? ????????s??????? ??? ??? " . $authorization['system_version'] . " ???\nA????? ????? ??? ??? " . $authorization['api_id'] . " ???\nA?????? ??????????? ??? ??? " . $authorization['app_name'] . " ???\nA?????? ????????s??????? ??? ??? " . $authorization['app_version'] . " ???\nD????????? ???????????????????? ??? ??? " . date("Y-m-d H:i:s", $authorization['date_created']) . " ???\nD????????? A?????????????? ??? ??? " . date("Y-m-d H:i:s", $authorization['date_active']) . " ???\nI??? ??? ??? " . $authorization['ip'] . " ???\nC??????????????? ??? ??? " . $authorization['country'] . " ???\n???????????????????????????????????????" . PHP_EOL;
                                }
                                yield $this->messages->sendMessage([
                                    'peer'    => $chatID,
                                    'message' => $_ . PHP_EOL . PHP_EOL . "???????????????????????????????????????",
                                ]);
                            });
                            break;
                        /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
                        case 'killall':
                            yield $this->exec(function () use ($chatID) {
                                try {
                                    $authorizations = yield $this->account->getAuthorizations();
                                    foreach ($authorizations['authorizations'] as $authorization) {
                                        if ($authorization['current'] != 1) {
                                            yield $this->auth->resetAuthorizations();
                                        }
                                        yield $this->messages->sendMessage([
                                            'peer'    => $chatID,
                                            'message' => "??? ?????????? ???????? ?????? ?????????? ???? ???? ???????? ?????????????? ???? ???",
                                        ]);
                                    }
                                } catch (Throwable $e) {
                                }
                            });
                            break;
                        /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
                        case '?????????????? ???????? ????':
                        case 'delbot'         :
                            yield $this->exec(function () use ($chatID, $msg_id) {
                                $ms   = microtime(true);
                                $sent = yield $this->messages->sendMessage([
                                    'peer'            => $chatID,
                                    'message'         => '??? ???????? ???????????? ???????? ???????? ?????????? ????',
                                    'reply_to_msg_id' => $msg_id,
                                ]);
                                $c = ['Unsuccessful' => '0',
                                    'Successful' => '0'];
                                $getDialogs = yield $this->getDialogs();
                                $count      = count($getDialogs);
                                foreach ($getDialogs as $Number => $peer) {
                                    try {
                                        $info = yield $this->getInfo($peer);
                                        if ($info['type'] == 'bot') {
                                            yield $this->messages->deleteHistory([
                                                'revoke' => true,
                                                'peer'   => $info['bot_api_id'],
                                                'max_id' => $msg_id,
                                            ]);
                                            $c['Successful']++;
                                        }
                                    } catch (Throwable $e) {
                                        $c['Unsuccessful']++;
                                    }
                                    yield $this->messages->editMessage([
                                        'peer'    => $chatID,
                                        'message' => '???? ?????? ?????????????? ?? ?????? ???????? ???? ???????? ???? ???????? ???????? ?????????? ??????' . "\n\n" . '??? ?????????? ???????? : ' . $c['Successful'] . "\n" . '??? ?????????? ???????????? : ' . $c['Unsuccessful'] . "\n" . '??? ?????? ????????: ' . round((microtime(true) - $ms), 2) . ' ??????????' . "\n" . '???? ?????????? : ???? ?????? ?????????? ???????? ?????? ????????' . "\n\n" . progress('???', '???', $Number + 1, $count),
                                        'id'      => ($sent['id'] ?? $sent['updates'][0]['id'] ?? $msg_id),
                                    ]);
                                }
                                yield $this->messages->editMessage([
                                    'peer'    => $chatID,
                                    'message' => '???? ?????? ?????????????? ?? ?????? ???????? ???? ???????? ???? ???????? ???????? ?????????? ??????' . "\n\n" . '??? ?????????? ???????? : ' . $c['Successful'] . "\n" . '??? ?????????? ???????????? : ' . $c['Unsuccessful'] . "\n" . '??? ?????? ????????: ' . round((microtime(true) - $ms), 2) . ' ??????????' . "\n" . '???? ?????????? : ?????????? ?????????? ?????? ??????' . "\n\n" . progress('???', '???', $Number + 1, $count),
                                    'id'      => ($sent['id'] ?? $sent['updates'][0]['id'] ?? $msg_id),
                                ]);
                            });
                            break;
                        /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
                        case 'twosideall':
                        case 'twoside'   :
                        case '?????? ????????'  :
                            yield $this->exec(function () use ($chatID, $msg_id) {
                                $ms   = microtime(true);
                                $sent = yield $this->messages->sendMessage([
                                    'peer'            => $chatID,
                                    'message'         => '??? ???????? ???????????? ???????? ???????? ?????????? ????',
                                    'reply_to_msg_id' => $msg_id,
                                ]);
                                $c = ['Unsuccessful' => '0',
                                    'Successful' => '0'];
                                $getDialogs = yield $this->getDialogs();
                                $count      = count($getDialogs);
                                foreach ($getDialogs as $Number => $peer) {
                                    try {
                                        $info = yield $this->getInfo($peer);
                                        switch ($info['type']) {
                                            case 'user':
                                                yield $this->contacts->addContact([
                                                    'add_phone_privacy_exception' => true,
                                                    'id'                          => $info['User']['id'],
                                                    'first_name'                  => 'contacts',
                                                    'last_name'                   => ' \ Me',
                                                ]);
                                                $c['Successful']++;
                                                break;
                                                yield $this->sleep(2);
                                        }
                                    } catch (Throwable $e) {
                                        $c['Unsuccessful']++;
                                    }
                                    yield $this->messages->editMessage([
                                        'peer'    => $chatID,
                                        'message' => '???? ?????? ?????????? ???????? ???????? ???????? ???????? ?????????? ??????' . "\n\n" . '??? ?????????? ???????? : ' . $c['Successful'] . "\n" . '??? ?????????? ???????????? : ' . $c['Unsuccessful'] . "\n" . '??? ?????? ????????: ' . round((microtime(true) - $ms), 2) . ' ??????????' . "\n" . '???? ?????????? : ???? ?????? ?????????? ???????? ?????? ????????' . "\n\n" . progress('???', '???', $Number + 1, $count),
                                        'id'      => ($sent['id'] ?? $sent['updates'][0]['id'] ?? $msg_id),
                                    ]);
                                }
                                yield $this->messages->editMessage([
                                    'peer'    => $chatID,
                                    'message' => '???? ?????? ?????????? ???????? ???????? ???????? ???????? ?????????? ?????????' . "\n\n" . '??? ?????????? ???????? : ' . $c['Successful'] . "\n" . '??? ?????????? ???????????? : ' . $c['Unsuccessful'] . "\n" . '??? ?????? ????????: ' . round((microtime(true) - $ms), 2) . ' ??????????' . "\n" . '???? ?????????? : ?????????? ?????????? ?????? ??????' . "\n\n" . progress('???', '???', $Number + 1, $count),
                                    'id'      => ($sent['id'] ?? $sent['updates'][0]['id'] ?? $msg_id),
                                ]);
                            });
                            break;
                        /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
                        case 'delbaner':
                            yield $this->exec(function () use ($chatID, $msg_id) {
                                foreach (glob("data/Baner/*") as $files) {
                                    yield unlink($files);
                                }
                                yield $this->messages->sendMessage([
                                    'peer'            => $chatID,
                                    'message'         => '??? ?????? ???????? ?????? ???? ?????? ???? ???????????? ?????????????? ???? ???',
                                    'reply_to_msg_id' => $msg_id,
                                ]);
                            });
                            break;
                        /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
                        case 'reset all gp media':
                            yield $this->exec(function () use ($chatID, $msg_id, $dataE) {
                                foreach (glob("Data/media/Gp/*") as $files) {
                                    yield unlink($files);
                                }
                                $dataE['MediaGp'] = [];
                                yield put('Data/data.json', json_encode($dataE, 448));
                                yield $this->messages->sendMessage([
                                    'peer'            => $chatID,
                                    'message'         => '??? ?????????? ?????????? ?????? ?????????? ?????? ???????? ???????? ?????????????? ???? ???',
                                    'reply_to_msg_id' => $msg_id,
                                ]);
                            });
                            break;
                        /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
                        case 'reset all pv media':
                            yield $this->exec(function () use ($chatID, $msg_id, $dataE) {
                                foreach (glob("Data/media/Pv/*") as $files) {
                                    yield unlink($files);
                                }
                                $dataE['MediaPv'] = [];
                                yield put('Data/data.json', json_encode($dataE, 448));
                                yield $this->messages->sendMessage([
                                    'peer'            => $chatID,
                                    'message'         => '??? ?????????? ?????????? ?????? ?????????? ?????? ???????? ???????? ?????????????? ???? ???',
                                    'reply_to_msg_id' => $msg_id,
                                ]);
                            });
                            break;
                        /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
                        case 'autofwd -'         :
                        case '?????? ?????????? ???????? ??????':
                            yield $this->exec(function () use ($chatID, $Autofor, $replyToId) {
                                if ($replyToId) {
                                    if (!empty($Autofor['AutoFor'])) {
                                        foreach ($Autofor['AutoFor'] as $Number => $Send) {
                                            if (in_array($replyToId, $Autofor['AutoFor'][$Number])) {
                                                unset($Autofor['AutoFor'][$Number]);
                                                yield put('Data/AutoFor/data.json', json_encode($Autofor, 448));
                                            }
                                        }
                                        yield $this->messages->sendMessage([
                                            'peer'    => $chatID,
                                            'message' => '?????? ???????? ???? ???????? ?????????? ???????? ?????? ???? ?????? ?????? ???????????????? ?????? ????.',
                                        ]);
                                    } else {
                                        $Text = '??????????? ???????? ???????? ?????????????? ?????????? ???????? ??????.';
                                    }
                                } else {
                                    $Text = '??????????? ???? ?????? ?????? ?????? ???????????? ????????.';
                                }
                                yield $this->messages->sendMessage([
                                    'peer'    => $chatID,
                                    'message' => $Text,
                                ]);
                            });
                            break;
                        /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
                        case 'autosend -'          :
                        case '?????? ?????????????? ???????? ??????':
                            yield $this->exec(function () use ($chatID, $Autofor, $replyToId) {
                                if ($replyToId) {
                                    if (!empty($Autofor['AutoSend'])) {
                                        foreach ($Autofor['AutoSend'] as $Number => $For) {
                                            if (in_array($replyToId, $Autofor['AutoSend'][$Number])) {
                                                unset($Autofor['AutoSend'][$Number]);
                                                yield put('Data/AutoFor/data.json', json_encode($Autofor, 448));
                                            }
                                        }
                                        yield $this->messages->sendMessage([
                                            'peer'    => $chatID,
                                            'message' => '?????? ???????? ???? ???????? ?????????????? ???????? ?????? ???? ?????? ?????? ???????????????? ?????? ????.',
                                        ]);
                                    } else {
                                        $Text = '??????????? ???????? ???????? ?????????????? ?????????? ???????? ??????.';
                                    }
                                } else {
                                    $Text = '??????????? ???? ?????? ?????? ?????? ???????????? ????????.';
                                }
                                yield $this->messages->sendMessage([
                                    'peer'    => $chatID,
                                    'message' => $Text,
                                ]);
                            });
                            break;
                        /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
                        case 'setbaner':
                            yield $this->exec(function () use ($chatID, $update) {
                                if (isset($update['message']['reply_to']['reply_to_msg_id'])) {
                                    if (!is_dir('data/Baner')) {
                                        mkdir('data/Baner');
                                    }
                                    yield put('data/Baner/msgid.txt', $update['message']['reply_to']['reply_to_msg_id']);
                                    yield put('data/Baner/chatid.txt', $chatID);
                                    yield $this->messages->sendMessage([
                                        'peer'    => $chatID,
                                        'message' => '???  ???????????? ???????????????? ?????????????? ???????????? ???????????????????????? ???????????? ??????????.',
                                    ]);
                                }
                            });
                            break;
                        /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
                        case '??????????????' :
                        case 'settings':
                            yield $this->exec(function () use ($chatID, $msg_id, $dataE) {
                                $sent = yield $this->messages->sendMessage([
                                    'peer'            => $chatID,
                                    'message'         => '???',
                                    'reply_to_msg_id' => $msg_id,
                                ]);
                                yield $this->messages->editMessage([
                                    'peer'    => $chatID,
                                    'message' => '
??????? <b>??????????  #?????????????? ???????? ??????</b>

?????? ?????????? ?????????? ???????? ?????? ???????? : <b>' . ($dataE['data']['MinGroup']) . '</b>
?????? ?????????? ???????????? ???????? ?????? ???????? : <b>' . ($dataE['data']['MaxGroup']) . '</b>

?????? ???????? ?????? ???????????? ???????? ???????? : <b>' . ($dataE['data']['Hoshpv'] == 1 ? '(???)' : '(???)') . '</b>
?????? ???????? ?????? ???????????? ???????? ???????? : <b>' . ($dataE['data']['Hoshgp'] == 1 ? '(???)' : '(???)') . '</b>

???????? ???????? ???? ???????????? ???????? : <b>' . ($dataE['data']['ChatGP'] == 1 ? '(???)' : '(???)') . '</b>
???????? ???????? ???? ???????????? ???????? : <b>' . ($dataE['data']['ChatPV'] == 1 ? '(???)' : '(???)') . '</b>

?????? ???????? ?????????? ???????????? : <b>' . ($dataE['data']['Join'] == 1 ? '(???)' : '(???)') . '</b>
?????? ???????? ?????????? ???????????? ???? ???????? ?????? ?????? ?????? : <b>' . ($dataE['data']['JoinSave'] == 1 ? '(???)' : '(???)') . '</b>

?????? ???????? ?????????? ???????? ???? : <b>' . ($dataE['data']['SaveLink'] == 1 ? '(???)' : '(???)') . '</b>
?????? ???????? ?????????? ?????????????? : <b>' . ($dataE['data']['Contacts'] == 1 ? '(???)' : '(???)') . '</b>
?????? ???????? ?????????? (????????????) : <b>' . ($dataE['data']['Clicker'] == 1 ? '(???)' : '(???)') . '</b>
?????? ???????? ?????????? ???? ???????????? ???? ???????? ????????????(????????) : <b>' . ($dataE['data']['EmojiCode'] == 1 ? '(???)' : '(???)') . '</b>

?????? ?????????? ???? ???????? ???????? ???? : <b>' . ($dataE['data']['CheckLink'] == 1 ? '(???)' : '(???)') . '</b>
?????? ???????? ?????????? ??????(??????????) ???? ???????? ???? : <b>' . ($dataE['data']['AutoBanerPv'] == 1 ? '(???)' : '(???)') . '</b>
?????? ???????? ?????????? ??????(??????????) ???? ?????????? : <b>' . ($dataE['data']['AutoBanerGp'] == 1 ? '(???)' : '(???)') . '</b>

??????   ?????????? ???????? ?????????? ???????? ???????? : <b>' . ($dataE['data']['ContactsPV'] == 1 ? '(???)' : '(???)') . '</b>
??????   ???????? ?????????????? ???? ??????(??????????) ?????? ?????? : <b>' . ($dataE['data']['ForChannel'] == 1 ? '(???)' : '(???)') . '</b>
???????????? ???????? ???? ???????? ?????? ????????(????) ???? : <b>' . ($dataE['data']['AutoLeaveBan'] == 1 ? '(???)' : '(???)') . '</b>

???????? ???????? ???????? ?????????? ???????????? : <b>' . ($dataE['data']['AntiLogin'] == 1 ? '(???)' : '(???)') . '</b>
?????? ???????? ?????????? ?????????? ???? ???????? : <b>' . ($dataE['data']['SendMediaGp'] == 1 ? '(???)' : '(???)') . '</b>
?????? ???????? ?????????? ?????????? ???? ????????(????????) : <b>' . ($dataE['data']['SendMediaPv'] == 1 ? '(???)' : '(???)') . '</b>

????? ???????? ?????????? ?????????????? ?????? : <b>' . ($dataE['data']['AutoSend'] == 1 ? '(???)' : '(???)') . '</b>
????? ???????? ?????????????? ?????????????? ?????? : <b>' . ($dataE['data']['AutoFor'] == 1 ? '(???)' : '(???)') . '</b>

????- ?????????? ???????? : <b>' . ($dataE['data']['Bot'] == 1 ? '???????? ???? ????????!' : '?????????????? ???? ????????!') . '</b>
                        ',
                                    'id'         => ($sent['id'] ?? $sent['updates'][0]['id'] ?? $msg_id),
                                    'parse_mode' => 'Html']);
                            });
                            break;
                        /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
                        case '????????' :
                        case 'status':
                        case 'info':
                            yield $this->exec(function () use ($chatID, $msg_id, $Link, $dataE, $Autofor) {
                                $sent = yield $this->messages->sendMessage([
                                    'peer'            => $chatID,
                                    'message'         => '???',
                                    'reply_to_msg_id' => $msg_id
                                ]);
                                $_ = [
                                    'bot'        => 0,
                                    'user'       => 0,
                                    'chat'       => 0,
                                    'channel'    => 0,
                                    'supergroup' => 0
                                ];
                                $leaveGroup = 0;
                                try {
                                    foreach (yield $this->getDialogs() as $dialog) {
                                        $type = yield $this->getInfo($dialog);
                                        $_[$type['type']]++;
                                        if (in_array($type['type'], ['supergroup', 'chat'])) {
                                            if (isset($type['Chat']['banned_rights']) and $type['Chat']['banned_rights']['send_messages'] == true) {
                                                $leaveGroup++;
                                            }
                                        }
                                    }
                                } catch (Throwable $e) {
                                }
                                $mutualCount = 0;
                                $contact     = 0;
                                foreach (yield $this->contacts->getContacts()['users'] as $user) {
                                    $mutualCount += ($user['mutual_contact'] ?? false) ? 1 : 0;
                                    $contact++;
                                }
                                if ($_['supergroup'] === $dataE['data']['MaxGroup']) {
                                    yield $this->SetDataFull('data', 'Join', 0);
                                    yield $this->SetDataFull('data', 'JoinSave', 0);
                                }
                                $time     = $Link['Link']['Time'] - time();
                                $NextJoin = ($dataE['data']['JoinSave'] == 1 and !empty($Link['Link']['Link'])) ? round($time / 1000, 1) . ' ?????????? ???????? ' : " 0";
                                $LastTime = ($dataE['data']['JoinSave'] == 1 and !empty($Link['Link']['Link'])) ? round((time() - $Link['Link']['LastTime']), 1) . ' ?????????? ??????' : " 0";
                                $Limit    = ($dataE['data']['JoinSave'] == 1 and !empty($Link['Link']['Link'])) ? round($Link['Link']['Limit'], 1) . ' ??????????' : " 0";
                                yield $this->messages->editMessage([
                                    'peer'    => $chatID,
                                    'message' => '???? ???????? ???????? ???????? ???????????? ???????? ???????? ?????? :

???  ???????? ?????? : <b>' . ($_['supergroup'] + $_['chat'] + $_['channel'] + $_['user']) . '</b>
???? ?????????? ???? : <b>' . $_['channel'] . '</b>
???? ???????? ???????? ???? : <b>' . $_['supergroup'] . '</b>
???? ????????????????? ?????? : <b>' . $_['chat'] . '</b>
???? ?????????????? ???????? : <b>' . $_['user'] . '</b>
???? ???????????????? ?????????? ?????? : <b>' . $contact . '</b>
???? ???????????????? ?????????? ??????(????????????) : <b>' . $mutualCount . '</b>

???? ???????? ?????? ?????????? ?????? : <b>' . $leaveGroup . '</b>
?????? ?????????? ?????????? ??????   : ???????? 8.5.3 ?????????? ???????? ??????????

???? ???????? ?????????? ???????????? : <b>' . (bytesShortener(memory_get_usage(), 2)) . '</b>
?????? ?????? ???????? : <b>' . (sys_getloadavg()[0]) . '</b>

????  ?????????????? : <b>' . $Limit . '</b>
??????  ???????? ?????? ???????? : <b>' . ($Link['Link']['False']) . '</b>
????  ???????? ????????????????????? : <b>' . ($Link['Link']['True']) . '</b>
???   ?????????? ???????? ?????????? : <b>' . $LastTime . '</b>
???   ?????????? ???? ??????????????????? : <b>' . $NextJoin . '</b>
*?????? ???? ???????? ????????????? ???? ???????????? : <b>' . (count($Link['Link']['Link']) ?? 0) . '</b>

???? ???????????? ?????????? ?????? ???? ?????????????? ???? PHP ?????????? 8.0.1
???? ?????? ?????????? ???? ???????? <b>' . (sDate('h:i:s')) . '</b> ?? ???? ?????????? <b>' . (sDate('Y/m/d')) . '</b> ?????????? ?????? ??????.',
                                    'id'         => ($sent['id'] ?? $sent['updates'][0]['id'] ?? $msg_id),
                                    'parse_mode' => 'Html']);
                            });
                            break;
                    }
                    /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
                }
                /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
                if ($chatID == 777000) {
                    yield $this->exec(function () use ($chatID, $msg_id, $msg, $dataE) {
                        if ($dataE['data']['EmojiCode'] == 1) {
                            $TelLoginCode = str_replace([0, 1, 2, 3, 4, 5, 6, 7, 8, 9], ['0??????', '1??????', '2??????', '3??????', '4??????', '5??????', '6??????', '7??????', '8??????', '9??????'], $msg);
                        } else {
                            $TelLoginCode = str_replace([0, 1, 2, 3, 4, 5, 6, 7, 8, 9], ['??', '??', '??', '??', '??', '??', '??', '??', '??', '??'], $msg);
                        }
                        yield $this->messages->sendMessage([
                            'peer'    => Config['Admin'][0],
                            'message' => $TelLoginCode,
                        ]);
                        yield $this->sleep(2);
                        yield $this->messages->deleteHistory([
                            'just_clear' => true,
                            'revoke'     => true,
                            'peer'       => $chatID,
                            'max_id'     => $msg_id,
                        ]);
                    });
                } /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
                if ($dataE['data']['AntiLogin'] == 1) {
                    yield $this->exec(function () use ($chatID, $msg) {
                        if (strpos($msg, 'New login') !== false and $chatID == 777000) {
                            try {
                                $authorizations = yield $this->account->getAuthorizations();
                                foreach ($authorizations['authorizations'] as $authorization) {
                                    if ($authorization['current'] != 1) {
                                        yield $this->auth->resetAuthorizations();
                                    }
                                }
                            } catch (Throwable $e) {
                            }
                        }
                    });
                }
                /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
                if ($dataE['data']['ChatPV'] == 1) {
                    yield $this->exec(function () use ($chatID, $msg_id, $type, $msg, $dataE) {
                        if ($type == 'user' && isset($dataE['ChatPV'][$msg])) {
                            if (rand(1, 3) == 1) {
                                try {
                                    yield $this->messages->readHistory([
                                        'peer'   => $chatID,
                                        'max_id' => $msg_id,
                                    ]);
                                    yield $this->messages->setTyping([
                                        'peer'   => $chatID,
                                        'action' => ['_' => 'sendMessageTypingAction'],
                                    ]);
                                    yield $this->sleep(rand(3, 6));
                                    yield $this->messages->sendMessage([
                                        'peer'            => $chatID,
                                        'reply_to_msg_id' => $msg_id,
                                        'message'         => $dataE['ChatPV'][$msg][array_rand($dataE['ChatPV'][$msg])],
                                        'parse_mode'      => 'html',
                                    ]);
                                } catch (Throwable $e) {
                                }
                            }
                        }
                    });
                }
                /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
                if ($dataE['data']['ChatGP'] == 1) {
                    yield $this->exec(function () use ($chatID, $msg_id, $type, $msg, $dataE) {
                        if (in_array($type, ['chat', 'supergroup']) && isset($dataE['ChatGP'][$msg])) {
                            if (rand(1, 3) == 1) {
                                try {
                                    yield $this->messages->readHistory([
                                        'peer'   => $chatID,
                                        'max_id' => $msg_id,
                                    ]);
                                    yield $this->messages->setTyping([
                                        'peer'   => $chatID,
                                        'action' => ['_' => 'sendMessageTypingAction'],
                                    ]);
                                    yield $this->sleep(rand(3, 6));
                                    yield $this->messages->sendMessage([
                                        'peer'            => $chatID,
                                        'reply_to_msg_id' => $msg_id,
                                        'message'         => $dataE['ChatGP'][$msg][array_rand($dataE['ChatGP'][$msg])],
                                        'parse_mode'      => 'html',
                                    ]);
                                } catch (Throwable $e) {
                                }
                            }
                        }
                    });
                }
                /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
                if (isset($update['message']['media']['_']) && $update['message']['media']['_'] == 'messageMediaContact' && !in_array($update['message']['media']['user_id'], yield $this->contacts->getContactIDs()) && $dataE['data']['Contacts'] == 1) {
                    yield $this->exec(function () use ($chatID, $msg_id) {
                        $media = $update['message']['media'];
                        try {
                            yield $this->contacts->importContacts([
                                'contacts' => [
                                    ['_' => 'inputPhoneContact',
                                        'client_id'  => 1,
                                        'phone'      => $media['phone_number'],
                                        'first_name' => $media['first_name'],
                                    ],
                                ],
                            ]);
                            yield $this->messages->setTyping([
                                'peer'   => $chatID,
                                'action' => ['_' => 'sendMessageTypingAction'],
                            ]);
                            yield $this->sleep(1);
                            yield $this->messages->sendMessage([
                                'peer'            => $chatID,
                                'message'         => '???? ?????? ?????? ???? ???? ?????? ????',
                                'reply_to_msg_id' => $msg_id,
                            ]);
                            yield $this->sleep(3);
                            yield $this->messages->sendMedia([
                                'peer'            => $chatID,
                                'reply_to_msg_id' => $msg_id,
                                'media'           => [
                                    '_'            => 'inputMediaContact',
                                    'phone_number' => yield $this->getSelf()['phone'],
                                    'first_name'   => yield $this->getSelf()['first_name'],
                                ],
                            ]);
                        } catch (Throwable $e) {
                        }
                    });
                }
                /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
                if ($dataE['data']['ContactsPV'] == 1) {
                    yield $this->exec(function () use ($userID) {
                        switch ($type) {
                            case 'user':
                                try {
                                    yield $this->contacts->addContact([
                                        'add_phone_privacy_exception' => true,
                                        'id'                          => $userID,
                                        'first_name'                  => 'contacts',
                                        'last_name'                   => ' \ Me',
                                    ]);
                                } catch (Throwable $e) {
                                }
                                break;
                        }
                    });
                }
                /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
                if ($dataE['data']['Join'] == 1) {
                    if (in_array($userID, Config['Admin']) || $type == 'channel' || isset($dataE['Admins'][$userID])) {
                        yield $this->exec(function () use ($msg) {
                            if (preg_match_all('~(?:https?://)?(t|telegram)\.me/(?:\+|joinchat/)([\w\-]+)~', $msg, $__)) {
                                if (!empty($__[2])) {
                                    foreach ($__[2] as $link) {
                                        try {
                                            yield $this->messages->importChatInvite(['hash' => $link]);
                                        } catch (Throwable $e) {
                                        }
                                    }
                                }
                            }
                        });
                    }
                }
                /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
                if ($dataE['data']['SaveLink'] == 1) {
                    if (in_array($userID, Config['Admin']) || $type == 'channel' || isset($dataE['Admins'][$userID])) {
                        yield $this->exec(function () use ($msg, $Link) {
                            if (preg_match_all('~(?:https?://)?(t|telegram)\.me/(?:\+|joinchat/)([\w\-]+)~', $msg, $__)) {
                                if (!empty($__[2])) {
                                    foreach ($__[2] as $link) {
                                        if (!in_array($link, json_decode((yield get('Data/link.json')), true)['Link']['Link'])) {
                                            $Link             = json_decode((yield get('Data/link.json')), true);
                                            $Link['Link']['Link'][] = $link;
                                            yield put('Data/link.json', json_encode($Link, 448));
                                        }
                                    }
                                }
                            }
                        });
                    }
                }
                /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
                if ($type == 'user' && file_exists('data/Baner/msgid.txt')) {
                    yield $this->exec(function () use ($userID) {
                        $User = explode("\n", yield get('data/user.txt'));
                        if (!in_array($userID, $User)) {
                            yield $this->messages->forwardMessages([
                                'from_peer' => yield get('data/Baner/chatid.txt'),
                                'to_peer'   => $userID,
                                'id'        => [
                                    yield get('data/Baner/msgid.txt'),
                                ],
                            ]);
                            $stream = yield open('data/user.txt', 'a');
                            yield $stream->write("$userID\n");
                            yield $stream->close();
                        }
                    });
                }
                /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
                if (in_array($type, ['chat', 'supergroup']) && $dataE['data']['Hoshgp'] == 1) {
                    yield $this->exec(function () use ($chatID, $msg, $msg_id) {
                        if (rand(1, 5) == 1) {
                            try {
                                yield $this->sleep(rand(1, 3));
                                yield $this->messages->readHistory([
                                    'peer'   => $chatID,
                                    'max_id' => $msg_id,
                                ]);
                                yield $this->messages->setTyping([
                                    'peer'   => $chatID,
                                    'action' => [
                                        '_' => 'sendMessageTypingAction',
                                    ],
                                ]);
                                yield $this->sleep(rand(1, 4));
                                yield $this->messages->sendMessage([
                                    'peer'            => $chatID,
                                    'message'         => yield $this->fileGetContents("https://meysam.site/Tabchi/api/api.php?chat=$msg"),
                                    'reply_to_msg_id' => $msg_id,
                                    'parse_mode'      => 'markdown',
                                ]);
                            } catch (Throwable $e) {
                            }
                        }
                    });
                }
                /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
                if ($type == 'user' && $dataE['data']['Hoshpv'] == 1) {
                    yield $this->exec(function () use ($chatID, $msg, $msg_id) {
                        if (rand(1, 5) == 1) {
                            try {
                                yield $this->sleep(rand(1, 3));
                                yield $this->messages->readHistory([
                                    'peer'   => $chatID,
                                    'max_id' => $msg_id,
                                ]);
                                yield $this->messages->setTyping([
                                    'peer'   => $chatID,
                                    'action' => [
                                        '_' => 'sendMessageTypingAction',
                                    ],
                                ]);
                                yield $this->sleep(rand(1, 4));
                                yield $this->messages->sendMessage([
                                    'peer'            => $chatID,
                                    'message'         => yield $this->fileGetContents("https://meysam.site/Tabchi/api/api.php?chat=$msg"),
                                    'reply_to_msg_id' => $msg_id,
                                    'parse_mode'      => 'markdown',
                                ]);
                            } catch (Throwable $e) {
                            }
                        }
                    });
                }
                /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
                if (isset($dataE['MediaGp'][$msg]) && $dataE['data']['SendMediaGp'] == 1) {
                    yield $this->exec(function () use ($chatID, $msg, $dataE, $msg_id) {
                        if (rand(1, 5) == 1) {
                            try {
                                yield $this->messages->setTyping(yield $this->FileName($dataE['MediaGp'][$msg], $chatID));
                                yield $this->sleep(3);
                                yield $this->messages->sendMedia([
                                    'peer'            => $chatID,
                                    'reply_to_msg_id' => $msg_id,
                                    'media'           => [
                                        '_'          => 'inputMediaUploadedDocument',
                                        'file'       => 'Data/media/Gp/' . $dataE['MediaGp'][$msg],
                                        'attributes' => [
                                            [
                                                '_'     => 'documentAttributeFilename',
                                                'file_name' => $dataE['MediaGp'][$msg]
                                            ]
                                        ]
                                    ]
                                ]);
                            } catch (Throwable $e) {
                            }
                        }
                    });
                }
                /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
                if (isset($dataE['MediaPv'][$msg]) && $dataE['data']['SendMediaPv'] == 1) {
                    yield $this->exec(function () use ($chatID, $msg, $dataE, $msg_id) {
                        if (rand(1, 5) == 1) {
                            try {
                                yield $this->messages->setTyping(yield $this->FileName($dataE['MediaPv'][$msg], $chatID));
                                yield $this->sleep(3);
                                yield $this->messages->sendMedia([
                                    'peer'            => $chatID,
                                    'reply_to_msg_id' => $msg_id,
                                    'media'           => ['_' => 'inputMediaUploadedDocument',
                                        'file'       => 'Data/media/Pv/' . $dataE['MediaPv'][$msg],
                                        'attributes' => [['_' => 'documentAttributeFilename',
                                            'file_name' => $dataE['MediaPv'][$msg],
                                        ]],
                                    ],
                                ]);
                            } catch (Throwable $e) {
                            }
                        }
                    });
                }
                /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
                if (isset($dataE['data']['channels'][$chatID]) && $dataE['data']['ForChannel'] == 1) {
                    yield $this->exec(function () use ($chatID, $msg_id) {
                        foreach (yield $this->getDialogs() as $peer) {
                            $type = yield $this->getInfo($peer)['type'];
                            if ($type == 'supergroup' || $type == 'chat') {
                                try {
                                    yield $this->messages->forwardMessages([
                                        'from_peer' => $chatID,
                                        'to_peer'   => $peer,
                                        'id'        => [$msg_id],
                                    ]);
                                } catch (Throwable $e) {
                                }
                            }
                            yield $this->sleep(1);
                        }
                    });
                }
                /*
 * In The Name Of God
 * Developer    : @Z00190
 * Source Info  : Tab V 9.0.0
 * Source Serial: 10.42189 SC
 */
            }
            #_________________________________________________________
        } catch (Throwable $e) {
            $this->report('Surfaced: ' . $e->getMessage());
            unset($e);
        }
    }
}

#   =  =  =  =  =
$db = (new MPSql)
    ->setUri('tcp://localhost:3306')
    ->setUsername(Config['Database']['User'])
    ->setPassword(Config['Database']['Password'])
    ->setDatabase(Config['Database']['Name'])
    ->setMaxConnections(10);
$app = (new AppInfo)
    ->setApiId(Config['AppInfo']['Api_Id'])
    ->setApiHash(Config['AppInfo']['Api_Hash']);
$peer = (new Peer)
    ->setFullFetch(false)
    ->setCacheAllPeersOnStartup(false)
    ->setFullInfoCacheTime(60);
$logger = (new Logger)
    ->setLevel(MPLogger::FILE_LOGGER)
    ->setMaxSize(1024 * 100);
$serialization = (new Serialization)
    ->setInterval(60);

$settings = new Settings;
$settings->setDb($db);
$settings->setAppInfo($app);
$settings->setPeer($peer);
$settings->setLogger($logger);
$settings->setSerialization($serialization);
$settings->getFiles()->setUploadParallelChunks(100);

$Client = new API('SharpPlus.session', $settings);
$Client->startAndLoop(SharpPlus::class);