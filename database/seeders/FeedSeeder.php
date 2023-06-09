<?php

namespace Database\Seeders;

use App\Managers\FeedManager;
use App\Models\Feed;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FeedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $feeds = array(
            [
                "name" => "ZDNET",
                "logo" => "https://cdn.cupinteractive.com/assets/zdnet/i/zdnet-rss-logo.gif",
                "url" => "https://www.zdnet.fr/blogs/security/rss/"
            ],
            [
                "name" => "ZDNET",
                "logo" => "https://cdn.cupinteractive.com/assets/zdnet/i/zdnet-rss-logo.gif",
                "url" => "https://www.zdnet.fr/blogs/cybervigilance/rss/"
            ],
            [
                "name" => "SecureID",
                "logo" => "http://securid.novaclic.com/wp-content/themes/shared/securid/images/logo.png",
                "url" => "https://securid.novaclic.com/feed"
            ],
            [
                "name" => "LeMondeInformatique",
                "logo" => "https://media-exp1.licdn.com/dms/image/C560BAQFt1yPpTO2UrA/company-logo_200_200/0?e=2159024400&v=beta&t=QtIYoNJQxveNK8yParxJK21F8dJ2Jq8KiALrzQetXWk",
                "url" => "https://www.lemondeinformatique.fr/flux-rss/thematique/securite/rss.xml"
            ],
            [
                "name" => "ZATAZ",
                "logo" => "https://pbs.twimg.com/profile_images/1115734966464405505/Ly9EJu5E_400x400.png",
                "url" => "https://www.zataz.com/rss/zataz-news.rss"
            ],
            // [
            //     "name" => "01net",
            //     "logo" => "https://www.01net.com/static/nxt-01net/info/applications/img/icone-01net.jpg",
            //     "url" => "https://www.01net.com/rss/actualites/securite/"
            // ],
            [
                "name" => "ITProNews",
                "logo" => "https://pbs.twimg.com/profile_images/1409440647/piclogo_400x400.jpg",
                "url" => "http://www.itpronews.fr/category/securite/feed"
            ],
            [
                "name" => "CERT-FR",
                "logo" => "https://www.cert.ssi.gouv.fr/images/logo_anssi.png",
                "url" => "https://www.cert.ssi.gouv.fr/alerte/feed/"
            ],
            [
                "name" => "CERT-FR",
                "logo" => "https://www.cert.ssi.gouv.fr/images/logo_anssi.png",
                "url" => "https://www.cert.ssi.gouv.fr/cti/feed/"
            ],
            [
                "name" => "CERT-FR",
                "logo" => "https://www.cert.ssi.gouv.fr/images/logo_anssi.png",
                "url" => "https://www.cert.ssi.gouv.fr/avis/feed/"
            ]
        );

        foreach ($feeds as $feed) {
            FeedManager::create($feed['name'], $feed['url'], $feed['logo']);
        }
    }
}
