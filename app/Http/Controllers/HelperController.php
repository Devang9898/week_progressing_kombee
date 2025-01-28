<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Support\Number;

class HelperController extends Controller
{
    public function arrayHelpers()
    {
        // Arr::accessible()
        $isAccessible1 = Arr::accessible(['a' => 1, 'b' => 2]);
        $isAccessible2 = Arr::accessible('abc');

        // Arr::add()
        $array = ['a' => 1, 'b' => 2];
        $addedArray = Arr::add($array, 'c', 3);
        $addedArray = Arr::add($addedArray, 'd', 4);

        // Arr::collapse()
        $arr1 = [1, 2, 3];
        $arr2 = [4, 5, 6];
        $collapsed = Arr::collapse([$arr1, $arr2]);

        // Arr::crossJoin()
        $matrix1 = Arr::crossJoin([1, 2], ['a', 'b']);
        $matrix2 = Arr::crossJoin([1, 2], ['a', 'b'], ['I', 'II']);

        // Arr::dot()
        $nestedArray = ['products' => ['desk' => ['price' => 100]]];
        $flattened = Arr::dot($nestedArray);

        // Arr::except()
        $array = ['name' => 'Desk', 'price' => 100];
        $filtered = Arr::except($array, ['price']);

        // Arr::first()
        $array = [100, 200, 300];
        $first = Arr::first($array, function ($value, $key) {
            return $value >= 250;
        });

        // Arr::flatten()
        $nestedArray = ['name' => 'Joe', 'languages' => ['PHP', 'Ruby']];
        $flattened = Arr::flatten($nestedArray);

        // Arr::sort()
        $array = ['Desk', 'Table', 'Chair'];
        $sortedAsc = Arr::sort($array);

        // Arr::sortDesc()
        $array = ['Desk', 'Table', 'Chair', 'zero', 'pillow'];
        $sortedDesc = Arr::sortDesc($array);

        // Arr::map()
        $array = ['first' => 'james', 'last' => 'kirk'];
        $mapped = Arr::map($array, function ($value, $key) {
            return ucfirst($value);
        });

        // Arr::random()
        $array = [1, 2, 3, 4, 5];
        $random = Arr::random($array);

        // Arr::set()
        $array = ['products' => ['desk' => ['price' => 100]]];
        Arr::set($array, 'products.desk.price', 200);

        return response()->json([
            'isAccessible' => [$isAccessible1, $isAccessible2],
            'addedArray' => $addedArray,
            'collapsed' => $collapsed,
            'matrix1' => $matrix1,
            'matrix2' => $matrix2,
            'flattened' => $flattened,
            'filtered' => $filtered,
            'first' => $first,
            'sortedAsc' => $sortedAsc,
            'sortedDesc' => $sortedDesc,
            'mapped' => $mapped,
            'random' => $random,
            'updatedArray' => $array,
        ]);
    }

    public function numberHelpers()
    {
        // Number::abbreviate()
        $abbr1 = Number::abbreviate(1000);
        $abbr2 = Number::abbreviate(489939);
        $abbr3 = Number::abbreviate(1230000, precision: 2);
        $abbr4 = Number::abbreviate(20000000000);

        // Number::clamp()
        $clamped1 = Number::clamp(5, min: 10, max: 100);
        $clamped2 = Number::clamp(1010, min: 10, max: 100);

        // Number::currency()
        $currencyDefault = Number::currency(1000);
        $currencyEUR = Number::currency(1000, in: 'EUR');
        $currencyINR = Number::currency(1000, in: 'INR');

        // Number::fileSize()
        $fileSize1 = Number::fileSize(1024);
        $fileSize2 = Number::fileSize(1024 * 1024 * 1024);

        // Number::forHumans()
        $human1 = Number::forHumans(1000);
        $human2 = Number::forHumans(489939);
        $human3 = Number::forHumans(1230000, precision: 2);
        $human4 = Number::forHumans(20000000000);

        // Number::format()
        $formatted1 = Number::format(100000);
        $formatted2 = Number::format(100000, precision: 2);
        $formatted3 = Number::format(100000.123, maxPrecision: 2);

        // Number::percentage()
        $percentage1 = Number::percentage(10);
        $percentage2 = Number::percentage(10, precision: 2);
        $percentage3 = Number::percentage(10.123, maxPrecision: 2);

        // Number::spell()
        $spelled = Number::spell(9999);

        return response()->json([
            'abbreviated' => [$abbr1, $abbr2, $abbr3, $abbr4],
            'clamped' => [$clamped1, $clamped2],
            'currency' => [$currencyDefault, $currencyEUR, $currencyINR],
            'fileSize' => [$fileSize1, $fileSize2],
            'forHumans' => [$human1, $human2, $human3, $human4],
            'formatted' => [$formatted1, $formatted2, $formatted3],
            'percentage' => [$percentage1, $percentage2, $percentage3],
            'spelled' => $spelled,
        ]);
    }

    public function urlHelpers()
    {
        // action()
        $actionUrl = action([HelperController::class, 'arrayHelpers']);

        // asset()
        $assetUrl = asset('img/photo.jpg');

        // route()
        $routeUrl = route('student_list');

        // secure_url()
        $secureUrl = secure_url('user/profile');

        // to_route()
        $toRouteUrl = to_route('student_list');

        // url()
        $baseUrl = url('student_list');

        return response()->json([
            'action' => $actionUrl,
            'asset' => $assetUrl,
            'route' => $routeUrl,
            'secureUrl' => $secureUrl,
            'toRoute' => $toRouteUrl,
            'url' => $baseUrl,
        ]);
    }

    public function miscellaneousHelpers()
    {
        // bcrypt()
        $bcrypt = bcrypt("secret");

        // encrypt() & decrypt()
        $encrypted = encrypt("Starship");
        $decrypted = decrypt($encrypted);

        // now() & today()
        $now = now();
        $today = today();

        // transform()
        $transformed = transform(100, fn($value) => $value * 2);

        // when()
        $whenTrue = when(5 > 4, 'Hello World');
        $whenFalse = when(3 > 4, 'Hello World');

        return response()->json([
            'bcrypt' => $bcrypt,
            'encrypted' => $encrypted,
            'decrypted' => $decrypted,
            'now' => $now,
            'today' => $today,
            'transformed' => $transformed,
            'whenTrue' => $whenTrue,
            'whenFalse' => $whenFalse,
        ]);
    }


    public function pathHelpers()
    {
        // app_path()
        $appPath = app_path();
        $appPathWithFile = app_path('Http/Controllers/Controller.php');

        // base_path()
        $basePath = base_path();
        $basePathWithFile = base_path('vendor/bin');

        // config_path()
        $configPath = config_path();
        $configPathWithFile = config_path('app.php');

        // database_path()
        $databasePath = database_path();
        $databasePathWithFile = database_path('factories/UserFactory.php');

        // lang_path()
        $langPath = lang_path();
        $langPathWithFile = lang_path('en/messages.php');

        return response()->json([
            'appPath' => $appPath,
            'appPathWithFile' => $appPathWithFile,
            'basePath' => $basePath,
            'basePathWithFile' => $basePathWithFile,
            'configPath' => $configPath,
            'configPathWithFile' => $configPathWithFile,
            'databasePath' => $databasePath,
            'databasePathWithFile' => $databasePathWithFile,
            'langPath' => $langPath,
            'langPathWithFile' => $langPathWithFile,
        ]);
    }
}
