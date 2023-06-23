<?php

namespace Tests\Unit\Services\TagsExtractor;

use App\Services\Scrapper\ScrapperService;
use App\Services\TagsExtractor\TagsExtractorService;
use Exception;
use Illuminate\Testing\Assert;
use Tests\TestCase;

class TagsExtractorServiceTest extends TestCase
{

    private $mockArticle = "Start-Up Nutanix, l’iPhone du datacenter débarque en France\n        Cloud & Datacenter : Forte de son succès outre-atlantique, cette start-up américaine entend bien secouer le marché européen avec son datacenter en boîte ultra convergent.\n        Non, ce n’est pas une nouvelle combinaison improbable entre du Nutella et du Weetabix, mais une start-up californienne qui veut incarner la prochaine génération d’infrastructure-celle après qui tout le monde court : ultra-virtualisée, ultra-élastique et ultra-performante.\n        Fondée en 2009, la start-up débarque désormais en France, avec la nomination de l’ex-directeur technique de VMware, Sylvain Siou. Ce dernier, qui avait eu du nez en choisissant de faire partie de la petite équipe qui a développé VMware en France il y a 9 ans aurait-il récidivé ? Nutanix pourrait-elle, elle aussi, devenir un futur succès à la manière de VMware ?\n        Au premier abord, on crie au loup : Nutanix réussit l’exploit d’écrire sur un même document marketing, «convergence», «software defined datacenter», «SSD Flash» et «Scale-out». Quoi, quatre buzz du moment réunis en une seule et même plateforme ? Et pourtant, après quelques recherches, il semblerait que la solution proposée soit réellement disruptive, et totalement dans l’air du temps. Nutanix est en tous les cas déjà un beau succès Outre-Atlantique, avec plus de 150 clients signés, dont Starbucks, eBay, et 71, 6 millions de dollars levés en trois tour de table auprès de capitaux-risqueurs comme Lightspeed Venture, Blumberg Capital, Khosla Venture et Goldman Sachs. Certains articles de presse comme celui-ci ont d’ailleurs pointé récemment la croissance fulgurante de l’entreprise, qui aurait dépassé presque toutes les entreprises spécialisées dans les datacenters, et parient sur une prochaine entrée en bourse. Forte de son succès, la société elle-même assure être en passe de devenir «l’iPhone du Datacenter» (!), soit en quelque sorte le nec plus ultra en la matière...Et aussi du vrai poil à gratter pour le marché.\n        Le Software-Defined-Datacenter, tendance lourde\n        On le sait, les infrastructures telles qu’elles sont construites aujourd’hui, ne pourront plus, à terme, répondre aux besoins des applications de demain. Le Cloud, le Big Data par exemple ont besoin d’infrastructures convergentes, évolutives, performantes et à bas coût. Jusque là, on fonctionnait en silo : les serveurs, le stockage, le réseau, même virtualisés.\n        La tendance forte est le «Software-Defined-Datacenter», concept lancé par Steve Herrod, ex-CTO de VMware lors de VMworld 2012. L’idée, déporter toute l’intelligence dans le logiciel- le matériel n’étant plus qu’une commodité- et en virtualisant toutes les composants en présence, pour donner naissance à une infrastructure flexible et évolutive à l’infini. VMware leader de la virtualisation est donc très bien placé pour y parvenir, surtout après ses deux acquisitions (Virsto et Nicira).\n        Dans ce contexte, Nutanix serait par ailleurs une des start-up les plus avancées dans le domaine. S’appuyant sur l’hyperviseur de VMware, et très apprécié dans les projets de VDI (avec View), Nutanix n’est pas à proprement parler un vrai concurrent de VMware, mais plutôt un partenaire. Cependant, son avance en fait aussi un compétiteur de choix. Et qui sait, VMware-ou EMC- aurait peut-être déjà bien envie de mettre la start-up dans sa besace prochainement...\n        Inspiré de Google\n        Pourquoi Nutanix attire-t-elle autant l’attention ? On l’a souvent dit, les datacenters de Google, de Amazon ou de Facebook, gigantesques et taillés pour les applications d'aujourd'hui, sont des références en matière de datacenters notamment pour leurs capacités à être massivement extensibles et à bas coût, tout en conservant de bonnes performances. Ce sont des modèles à suivre pour les datacenters de nouvelle génération. Et ça tombe bien. Une partie de l'équipe de Nutanix est dirigée par les mêmes dévelopeurs et architectes qui ont créé le système de fichier de Google (mais aussi de talents issus de Facebook, Amazon, Microsoft, VMware, Oracle...). Nutanix veut donc mettre à disposition des entreprises une architecture semblable à celle que Google utilise dans ses propres datacenters.\n        Datacenter in a box\n        Nutanix Complete Cluster est donc une architecture totalement convergée. Elle fusionne les ressources jusque là séparées -serveurs et stockage de commodité -dans un seul et même cluster, sorte de brique de base 2U. Selon Nutanix, ce datacenter in a box se déploie en moins de 30 minutes et peut s’empiler à l’infini ou presque (jusqu’à 1000 noeuds possibles selon la documentation), ce qui permet de commencer petit et faire grandir l’infrastructure au fur et à mesure. Selon Howard Ting, VP of Marketing chez Nutanix, « il s’agit d’une véritable convergence «by design», contrairement aux infrastructures packagées du marché, qui ne font qu’assembler serveurs, stockage et réseau, et qui ne résolvent pas toutes les problématiques liées à la virtualisation». A noter l’utilisation de cartes Fusion i/o sur lesquelles les données sont stockées et répliquées, et l’hyperviseur de VMware ESXi pour la virtualisation.\n        Stockage Scale-Out \n        Chaque noeud est une appliance virtuelle de stockage. La technologie Scale Out Converged Storage (SOCS) virtualise tout le stockage local des serveurs en un pool unifié, qui sert en quelque sorte de SAN local, pour fournir du stockage aux VMs sous la forme de vDisks, montés localement dans une VM, et déplacés d’un noeud à l’autre grâce à VMotion. Une machine virtuelle peut ainsi écrire des données n’importe où dans le cluster, et n’est pas limitée au stockage local du noeud dans lequel elle se trouve. Bien entendu, les disques flash permettent plus de performances pour les données actives, les disques SATA pour les données moins actives. D’autres clusters comme ceux de Isilon ou de 3PAR ont des noeuds qui partagent aussi la mémoire et le stockage, avec cohérence de cache, mais à mesure qu’ils grandissent requièrent de plus en plus d’organisation pour coordonner le cluster. Xtremio de EMC est de son côté limité à 8 noeuds. Si Nutanix est pour l’instant très lié à l’hyperviseur de VMware, il ne s’interdit pas à l’avenir d’en supporter d’autres. D’autres start-ups sur le marché, comme Tintri, Tegile, visent aussi le software-defined, mais proposent des appliances combinant uniquement flash et disque. Nutanix a cela de plus qu’il a ajouté les ressources serveur.\n        Du SAN sans le SAN, du NFS, sans N\n        Nutanix dit «faire du SAN sans le SAN», et «du NFS sans le N». En virtualisant le stockage DAS inclus dans les serveurs, Nutanix rend en effet le SAN obsolète. Une idée qui court depuis longtemps, une nouvelle fois concrétisée par Nutanix. A la manière du «no software» de Salesforce, la société affiche d’ailleurs fièrement un «no SAN» sur ses clusters. Bien évidemment, selon Howard Ting, l’idée n’est pas dans un premier temps de mettre son SAN à la poubelle, mais de pouvoir envisager une nouvelle architecture lorsque le renouvellement se fait sentir. Nutanix dit «faire du SAN sans le SAN, et du NFS sans le N». Aussi sans le coût du SAN, puisque Nutanix offrirait selon ses dires, un rapport prix/performance entre 5 et 10 fois supérieur à une approche serveurs + SAN traditionnelle.\n        Exclusive Networks distributeur officiel en Europe.\n        CVE-2023-34105 CVE-2023-34104 oSx.\n        En pratique, Nutanix peut globalement adresser plusieurs types de problématiques, mais elle s’est rapidement fait connaître dans les projets VDI, notamment parce qu’il permet de réduire considérablement les coûts de stockage. Elle a \n        d’ailleurs annoncé sa compatibilité avec VMware Horizon récemment. En Europe, la société a signé un accord pan-européen avec le distributeur Exclusive Networks dans six pays. Objectif : monter le réseaux de distribution, puisque Nutanix est sur un modèle totalement indirect.";

    private $textWithCharsToOmit = "Le nombre '42` est ’+la .'réponse à la &grande question sur !?: la vie,;l'univers# et ~le =/reste $ £^()_<>«»";

    private $mockArticleWithCve = "Start-Up NutaCVE-2023-33693nix, l’iPhone CVE-2023-24403 du datacenter CVE-2023-2417 débarque CVE-2023-bibibi  en CVE-bibi-70708 France";

    private $mockArticleWithExtraWords = "Start-Up WiNdoWs, l’apple iPhone du datacenter débarque en France, Cloud & Datacenter : Forte de son succès outre-atlantique, cette start-up américaine. ESXi...";

    private $mockArticleWithExtraWordsDuplicate = "Start-Up WiNdoWs, l’apple iPhone du datacenter débarque en France WiNdoWs WiNdoWs, Cloud & Datacenter : Forte de son succès outre-atlantique, cette start-up américaine. ESXi...";

    public function testGetResultWithPhpml()
    {
        $service = new TagsExtractorService();
        $response = $service->getResult('phpml', $this->mockArticle);
        Assert::assertNotNull($response);
        Assert::assertIsArray($response);
    }

    public function testGetResultWithRakephp()
    {
        $service = new TagsExtractorService();
        $response = $service->getResult('rakeplus', $this->mockArticle);
        Assert::assertNotNull($response);
        Assert::assertIsArray($response);
    }

    public function testGetResultWithTextrank()
    {
        $service = new TagsExtractorService();
        $response = $service->getResult('textrank', $this->mockArticle);
        Assert::assertNotNull($response);
        Assert::assertIsArray($response);
    }

    public function testGetResultWithWrongLib()
    {
        $service = new TagsExtractorService();

        $this->expectException(Exception::class);
        $service->getResult('wronglib', $this->mockArticle);
    }

    public function testCleanText()
    {
        $service = new TagsExtractorService();

        $cleanText = $service->cleanText($this->textWithCharsToOmit, 2, false);
        Assert::assertIsString($cleanText);
        Assert::assertEquals("le nombre  42  est   la   réponse à la  grande question sur     la vie  l univers  et  le   reste            ", $cleanText);
    }

    public function testDeleteSmallWordsFromArray()
    {
        $service = new TagsExtractorService();

        $wordsArray = ['le', 'nombre', '42', 'est', 'la', 'réponse', 'à', 'la', 'grande', 'question', 'sur', 'la', 'vie'];

        $wordsArrayClean = $service->deleteSmallWordsFromArray($wordsArray);


        Assert::assertIsArray($wordsArrayClean);
        Assert::assertSame(array_values(['nombre', 'est', 'réponse', 'grande', 'question', 'sur', 'vie']), array_values($wordsArrayClean));
        Assert::assertEquals(7, sizeof($wordsArrayClean));
    }

    public function testDeleteSmallWordsFromArrayWithNumber()
    {
        $service = new TagsExtractorService();

        $wordsArray = ['le', 'nombre', '42', 'est', 'la', 'réponse', 'à', 'la', 'grande', 'question', 'sur', 'la', 'vie'];

        $wordsArrayClean = $service->deleteSmallWordsFromArray($wordsArray, 2, true);


        Assert::assertIsArray($wordsArrayClean);
        Assert::assertSame(array_values(['nombre', '42', 'est', 'réponse', 'grande', 'question', 'sur', 'vie']), array_values($wordsArrayClean));
        Assert::assertEquals(8, sizeof($wordsArrayClean));
        Assert::assertEquals(13, sizeof($wordsArray));
    }

    public function testExtractCve()
    {
        $service = new TagsExtractorService();
        $cveList = $service->extractCve($this->mockArticleWithCve);

        Assert::assertIsArray($cveList);
        Assert::assertSame(['CVE-2023-33693', 'CVE-2023-24403', 'CVE-2023-2417'], $cveList);
    }

    public function testExtractExtraWords()
    {
        $service = new TagsExtractorService();
        $extraWords = $service->extractExtraWords($this->mockArticleWithExtraWords);

        Assert::assertIsArray($extraWords);
        Assert::assertSame(['windows', 'apple', 'esxi'], $extraWords);
    }

    public function testExtractExtraWordsWithDuplicates()
    {
        $service = new TagsExtractorService();
        $extraWords = $service->extractExtraWords($this->mockArticleWithExtraWordsDuplicate);

        Assert::assertSame(\array_values(['windows', 'apple', 'esxi']), \array_values($extraWords));
    }

    public function testGetStopWords()
    {
        $service = new TagsExtractorService();
        $stopWords = $service->getStopWords('fr');

        Assert::assertIsArray($stopWords);
    }

    public function testGetStopWordsWithBadLocale()
    {
        $service = new TagsExtractorService();

        $this->expectException(Exception::class);
        $service->getStopWords('qsdsdqs');
    }
}
