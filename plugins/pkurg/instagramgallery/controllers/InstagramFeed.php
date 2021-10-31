<?php namespace Pkurg\InstagramGallery\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Cache;
use Input;
use Phpfastcache\Helper\Psr16Adapter;
use Pkurg\InstagramGallery\Models\Settings;
use Response;
use Storage;
use \Carbon\Carbon;

class Client extends \GuzzleHttp\Client implements \Psr\Http\Client\ClientInterface
{
    /**
     * @inheritDoc
     */
    public function sendRequest(\Psr\Http\Message\RequestInterface $request): \Psr\Http\Message\ResponseInterface
    {
        return $this->send($request);
    }

}

/**
 * Instagram Feed Back-end Controller
 */
class InstagramFeed extends Controller
{

    /**
     * @var array Behaviors that are implemented by this controller.
     */
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
    ];

    /**
     * @var string Configuration file for the `FormController` behavior.
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string Configuration file for the `ListController` behavior.
     */
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Pkurg.InstagramGallery', 'instagramgallery', 'instagramfeed');
    }

    public function checkConnection()
    {

        $login = Input::get('login');
        $pass = Input::get('pass');

        $instagram = \InstagramScraper\Instagram::withCredentials(new Client(), $login, $pass, new Psr16Adapter('Files'));
        $res = @$instagram->login();

        return Response::JSON(true);

    }

    public function getImage($id, $url, $index)
    {

        $file_name = 'media/InstagramFeed/' . $id . '-' . $index . '-' . '.jpg';

        $exists = Storage::exists($file_name);

        if (!$exists) {

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                //echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);

            Storage::put($file_name, $result);
        }

        return url('/storage/app/' . $file_name);

    }

    public function UpdateFeed()
    {

        $id = Input::get('id');
        $user = Input::get('user');
        $postcount = Input::get('postcount');
        $period = Input::get('period');
        $key = Input::get('key');
        $tkey = Input::get('tkey');
        $propkey = Input::get('propkey');
        $size_index = Input::get('size');

        $instagram = \InstagramScraper\Instagram::withCredentials(new Client(), Settings::get('login'), Settings::get('pass'), new Psr16Adapter('Files'));

        $instagram->login();

        $instagram->saveSession(90000);

        $nonPrivateAccountMedias = $instagram->getMedias($user, $postcount);

        $data = [];

        foreach ($nonPrivateAccountMedias as $value) {

            $i["id"] = $value->getId();
            $i["link"] = $value->getLink();
            $i["img"] = $this->getImage($value->getId(), $value->getSquareImages()[$size_index], $size_index);
            $i["caption"] = $string = trim(preg_replace('/\s+/', ' ', $value->getCaption()));
            $data[$value->getId()] = $i;
        }

        $exp = Carbon::now()->addHours($period);
        //$exp = Carbon::now()->addMinutes($period);
        Cache::put($key, $data, $exp);
        Cache::forever($tkey, $data);

        return response()->json(
            [
                'html' => view("pkurg.instagramgallery::feed", ['feed' => $data])->render(),
            ]
        );

    }

}
