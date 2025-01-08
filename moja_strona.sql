-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2025 at 05:58 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `moja_strona`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT 0,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `page_list`
--

CREATE TABLE `page_list` (
  `id` int(11) NOT NULL,
  `page_title` varchar(255) DEFAULT NULL,
  `height` varchar(50) NOT NULL,
  `page_content` text DEFAULT NULL,
  `status` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `page_list`
--

INSERT INTO `page_list` (`id`, `page_title`, `height`, `page_content`, `status`) VALUES
(1, 'Burdż Chalifa', '828 m', '<!DOCTYPE html>\r\n<html lang=\"en\">\r\n<head>\r\n    <meta http-equiv=\"Content-type\" content=\"text/html; charset=UTF-8\" />\r\n    <meta http-equiv=\"Content-Language\" content=\"pl\" />\r\n    <meta name=\"Author\" content=\"Michał Kaczmarczyk\" />\r\n    <title>Burj Khalifa</title>\r\n    <link rel=\"stylesheet\" href=\"../css/styles.css\">\r\n</head>\r\n<body>\r\n<div class=\"burj-khalifa\">\r\n    <div class=\"content-layout\">\r\n        <!-- Obraz z lewej strony -->\r\n        <div class=\"image-left\">\r\n            <img src=\"../img/Burj_Khalifa.jpg\" alt=\"Burj Khalifa\">\r\n        </div>\r\n\r\n        <!-- Tekst na środku -->\r\n        <div class=\"text-center\">\r\n            <h1>Burj Khalifa</h1>\r\n            <p>\r\n                Burj Khalifa, znany również jako Wieża Chalifa, to jedna z najbardziej imponujących i ikonicznych budowli na świecie.\r\n                Znajduje się w Dubaju, Zjednoczonych Emiratach Arabskich, i jest to najwyższy budynek na świecie, sięgający niesamowitej wysokości 828 metrów.\r\n                Budowa Burj Khalifa rozpoczęła się w 2004 roku i zakończyła w 2010 roku, a jej koszt wyniósł około 1,5 miliarda dolarów.\r\n                Ta monumentalna wieża jest prawdziwym arcydziełem inżynierii i architektury.\r\n            </p>\r\n\r\n            <p>\r\n                Wieża Burj Khalifa ma wiele imponujących rekordów na swoim koncie, m.in. najwyższą wieżę telewizyjną na świecie oraz\r\n                najwyższy punkt obserwacyjny dostępny publiczności. Budynek jest również znany z wyjątkowej fasady, która jest pokryta tysiącami paneli szklanymi,\r\n                nadając mu niepowtarzalny wygląd. To miejsce przyciąga turystów z całego świata, którzy przybywają tu, aby podziwiać panoramę Dubaju z wysokości wieży.\r\n            </p>\r\n\r\n            <p>\r\n                Burj Khalifa nie jest jedynie imponującą budowlą, ale także ważnym centrum kultury i rozrywki w Dubaju.\r\n                Wewnątrz budynku znajdują się luksusowe apartamenty, hotele, restauracje, galerie sztuki i teatry. Wieża jest również otoczona pięknym\r\n                parkiem i sztucznym jeziorem, tworzącym spektakularne widowisko świetlne wieczorami.\r\n            </p>\r\n\r\n            <p>\r\n                Burj Khalifa jest symbolicznie ważny dla Dubaju i stanowi dowód na rozwijający się gospodarczo i architektonicznie charakter tego miasta.\r\n                Jest to ikona współczesnej architektury i inżynierii, która zapiera dech w piersiach i przyciąga uwagę całego świata.\r\n            </p>\r\n        </div>\r\n\r\n        <!-- Obraz z prawej strony -->\r\n        <div class=\"image-right\">\r\n            <img src=\"../img/burj2.jpg\" alt=\"Burj Khalifa Night\">\r\n        </div>\r\n    </div>\r\n</div>\r\n</body>\r\n</html>\r\n', 1),
(2, 'Merdeka', '678.9 m', '<!DOCTYPE html>\r\n<html lang=\"en\">\r\n<head>\r\n    <meta http-equiv=\"Content-type\" content=\"text/html; charset=UTF-8\" />\r\n    <meta http-equiv=\"Content-Language\" content=\"pl\" />\r\n    <meta name=\"Author\" content=\"Michał Kaczmarczyk\" />\r\n    <link rel=\"stylesheet\" href=\"../css/styles.css\">\r\n    <title>Merdeka</title>\r\n</head>\r\n<body>\r\n<div class=\"merdeka\">\r\n    <div class=\"content-layout\">\r\n        <!-- Obraz z lewej strony -->\r\n        <div class=\"image-left\">\r\n            <img src=\"../img/merdeka.jpg\" alt=\"Merdeka 118\">\r\n        </div>\r\n\r\n        <!-- Tekst na środku -->\r\n        <div class=\"text-center\">\r\n            <h1>Merdeka 118</h1>\r\n            <p>\r\n                Merdeka 118 to nowoczesny wieżowiec zlokalizowany w Kuala Lumpur, Malezja. \r\n                Jest częścią większego projektu, który ma na celu rozwój obszaru wokół historycznego stadionu Merdeka.\r\n                Budynek ma imponującą wysokość, co czyni go jednym z najwyższych w mieście i symbolem nowoczesnej \r\n                architektury.\r\n            </p>\r\n\r\n            <p>\r\n                Wieżowiec zaprojektowany przez renomowaną pracownię architektoniczną wyróżnia się unikalnym stylem \r\n                oraz nowoczesnymi rozwiązaniami technologicznymi. Zawiera biura, przestrzenie komercyjne oraz luksusowe\r\n                apartamenty, co sprawia, że jest atrakcyjnym miejscem dla inwestorów i mieszkańców.\r\n            </p>\r\n\r\n            <p>\r\n                Merdeka 118 ma również znaczenie kulturowe, łącząc nowoczesność z bogatą historią Kuala Lumpur.\r\n                Bliskość do takich miejsc jak stadion Merdeka i inne atrakcje turystyczne sprawia, że staje się\r\n                ważnym punktem na mapie miasta.\r\n            </p>\r\n\r\n            <p>\r\n                Projekt ten ma na celu nie tylko rozwój infrastruktury, ale także promowanie zrównoważonego \r\n                rozwoju. W planach uwzględniono elementy zielonej architektury, co ma pozytywny wpływ na środowisko \r\n                miejskie oraz jakość życia mieszkańców.\r\n            </p>\r\n        </div>\r\n\r\n        <!-- Obraz z prawej strony -->\r\n        <div class=\"image-right\">\r\n            <img src=\"../img/merdeka2.jpg\" alt=\"Merdeka 118 Night\">\r\n        </div>\r\n    </div>\r\n</div>\r\n</body>\r\n</html>\r\n', 1),
(3, 'Shanghai Tower', '632 m', '<!DOCTYPE html>\r\n<html lang=\"en\">\r\n<head>\r\n    <meta http-equiv=\"Content-type\" content=\"text/html; charset=UTF-8\" />\r\n    <meta http-equiv=\"Content-Language\" content=\"pl\" />\r\n    <meta name=\"Author\" content=\"Michał Kaczmarczyk\" />\r\n    <title>Shanghai Tower</title>\r\n    <link rel=\"stylesheet\" href=\"../css/styles.css\">\r\n</head>\r\n<body>\r\n<div class=\"shanghai-tower\">\r\n    <div class=\"content-layout\">\r\n        <!-- Obraz z lewej strony -->\r\n        <div class=\"image-left\">\r\n            <img src=\"../img/Shanghai_Tower.jpg\" alt=\"Shanghai Tower\">\r\n        </div>\r\n\r\n        <!-- Tekst na środku -->\r\n        <div class=\"text-center\">\r\n            <h1>Shanghai Tower</h1>\r\n            <p>\r\n                Shanghai Tower to niezwykle imponujący wieżowiec, który znajduje się w sercu Szanghaju, Chin.\r\n                Jest to jedna z najwyższych wież na świecie i jedna z trzech wież w kompleksie budynków o nazwie \"Shanghai World Financial Center\".\r\n                Shanghai Tower został ukończony w 2015 roku i jest symbolem nowoczesności i postępu tego chińskiego miasta.\r\n            </p>\r\n\r\n            <p>\r\n                Głównym celem projektantów Shanghai Tower było stworzenie budynku przyjaznego dla środowiska.\r\n                Wieżowiec jest wyposażony w liczne zaawansowane technologie, które pozwalają na oszczędność energii i zmniejszenie emisji CO2.\r\n                Jego charakterystyczna spiralna forma nie tylko zapewnia unikalny wygląd, ale także pomaga w redukcji oporu wiatru, co wpływa na\r\n                efektywność energetyczną budynku.\r\n            </p>\r\n\r\n            <p>\r\n                Wnętrze Shanghai Tower jest równie wspaniałe co jego zewnętrzna forma.\r\n                W wieżowcu znajduje się wiele pięter przeznaczonych na biura, a także luksusowy hotel oraz liczne restauracje i\r\n                punkty widokowe. Jednak to widok z najwyższego punktu obserwacyjnego, który znajduje się na wysokości 632 metrów, zapiera dech w piersiach.\r\n                Z tego miejsca można podziwiać niesamowitą panoramę Szanghaju i jego otoczenia.\r\n            </p>\r\n\r\n            <p>\r\n                Shanghai Tower stanowi przykład chińskiej determinacji i zdolności do realizacji ambitnych projektów architektonicznych.\r\n                To nie tylko wieżowiec, ale również symbol postępu i nowoczesności, który przyciąga uwagę turystów i mieszkańców Szanghaju,\r\n                jak również inspiruje innych projektantów na całym świecie.\r\n            </p>\r\n        </div>\r\n\r\n        <!-- Obraz z prawej strony -->\r\n        <div class=\"image-right\">\r\n            <img src=\"../img/ST.jpg\" alt=\"Shanghai Tower Night\">\r\n        </div>\r\n    </div>\r\n</div>\r\n</body>\r\n</html>\r\n', 1),
(4, 'Abradż al-Bajt', '601 m', '<!DOCTYPE html>\r\n<html lang=\"en\">\r\n<head>\r\n    <meta http-equiv=\"Content-type\" content=\"text/html; charset=UTF-8\" />\r\n    <meta http-equiv=\"Content-Language\" content=\"pl\" />\r\n    <meta name=\"Author\" content=\"Michał Kaczmarczyk\" />\r\n    <title>Abradż al-Bajt</title>\r\n    <link rel=\"stylesheet\" href=\"../css/styles.css\">\r\n</head>\r\n<body>\r\n<div class=\"abradz-al-bajt\">\r\n    <div class=\"content-layout\">\r\n        <!-- Obraz z lewej strony -->\r\n        <div class=\"image-left\">\r\n            <img src=\"../img/alb.jpg\" alt=\"Abradż al-Bajt\">\r\n        </div>\r\n\r\n        <!-- Tekst na środku -->\r\n        <div class=\"text-center\">\r\n            <h1>Abradż al-Bajt</h1>\r\n            <p>\r\n                Abradż al-Bajt, znany także jako Domek Allaha lub Kubba Bajt Allah,\r\n                to jedno z najważniejszych miejsc w islamie i znajduje się w Mekce, Arabii Saudyjskiej.\r\n                Jest to niewielka, ale niezwykle święta budowla w kształcie sześcianu, która jest centralnym punktem w kompleksie Masjid al-Haram,\r\n                najświętszej meczecie islamu. To miejsce jest szczególnie ważne dla muzułmanów, ponieważ jest miejscem,\r\n                w którym kierują swoje modlitwy podczas obowiązkowej modlitwy pięć razy dziennie.\r\n            </p>\r\n\r\n            <p>\r\n                Historia Abradż al-Bajt sięga tysięcy lat wstecz i jest związana z prorokiem Abrahamem\r\n                i jego synem Ismaelem, którzy wg islamskich tradycji zbudowali tę świątynię na polecenie Boga.\r\n                Owa legenda opowiada o ich lojalności i oddaniu wobec Boga. Domek Allaha został wielokrotnie przebudowany i odrestaurowany w ciągu wieków,\r\n                a obecna konstrukcja jest zadaszonym budynkiem, który został zmodernizowany wiele razy.\r\n            </p>\r\n\r\n            <p>\r\n                Co roku miliony muzułmanów z całego świata przybywają do Mekki, aby wziąć udział w pielgrzymce zwanej hadżdżem,\r\n                podczas której modlą się w kierunku Abradż al-Bajt. To jedno z pięciu filarów islamu i obowiązek religijny dla wszystkich muzułmanów,\r\n                którzy są w stanie to zrobić. Abradż al-Bajt symbolizuje jedność i wspólnotę muzułmańskiej wspólnoty, ponieważ modlą się w tym samym kierunku,\r\n                niezależnie od swojego pochodzenia czy kultury.\r\n            </p>\r\n\r\n            <p>\r\n                Warto podkreślić, że dostęp do Abradż al-Bajt jest ograniczony tylko dla muzułmanów,\r\n                a dla pozostałych osób jest to miejsce niedostępne. Jest to związane z wyjątkową świętością tego miejsca dla muzułmańskiej religii i kultury,\r\n                co czyni je jednym z najbardziej wyjątkowych i niesamowitych miejsc na świecie.\r\n            </p>\r\n        </div>\r\n\r\n        <!-- Obraz z prawej strony -->\r\n        <div class=\"image-right\">\r\n            <img src=\"../img/alb2.jpg\" alt=\"Abradż al-Bajt nocą\">\r\n        </div>\r\n    </div>\r\n</div>\r\n</body>\r\n</html>\r\n', 1),
(5, 'Ping An Finance Center', '599 m', '<!DOCTYPE html>\r\n<html lang=\"en\">\r\n<head>\r\n    <meta http-equiv=\"Content-type\" content=\"text/html; charset=UTF-8\" />\r\n    <meta http-equiv=\"Content-Language\" content=\"pl\" />\r\n    <meta name=\"Author\" content=\"Michał Kaczmarczyk\" />\r\n    <title>Ping An Finance Center</title>\r\n    <link rel=\"stylesheet\" href=\"../css/styles.css\">\r\n</head>\r\n<body>\r\n<div class=\"ping-an-finance-center\">\r\n    <div class=\"content-layout\">\r\n        <!-- Obraz z lewej strony -->\r\n        <div class=\"image-left\">\r\n            <img src=\"../img/paif.jpg\" alt=\"Ping An Finance Center\">\r\n        </div>\r\n\r\n        <!-- Tekst na środku -->\r\n        <div class=\"text-center\">\r\n            <h1>Ping An Finance Center</h1>\r\n            <p>\r\n                Ping An Finance Center to znakomity przykład nowoczesnej architektury i projektu urbanistycznego,\r\n                znajdujący się w Shenzhen, Chińskiej Republice Ludowej. Jest to jedno z najwyższych budynków na świecie,\r\n                osiągające wysokość aż 599 metrów, co czyni je jednym z charakterystycznych elementów panoramy tego dynamicznego miasta.\r\n                Budowa Ping An Finance Center została ukończona w 2017 roku i od tego czasu stanowi symbol postępu gospodarczego i\r\n                rozwoju technologicznego w Chinach.\r\n            </p>\r\n\r\n            <p>\r\n                Budynek ten jest siedzibą firmy Ping An Insurance Group,\r\n                jednego z największych ubezpieczycieli na świecie, co nadaje mu znaczenie zarówno ekonomiczne, jak i kulturowe.\r\n                Ping An Finance Center wyróżnia się nowoczesną i futurystyczną architekturą, a jego charakterystyczną cechą jest niebieska,\r\n                opalizująca fasada, która nadaje budynkowi niepowtarzalny wygląd. Wnętrze budynku również imponuje, oferując przestrzenie biurowe i\r\n                handlowe na najwyższym poziomie.\r\n            </p>\r\n\r\n            <p>\r\n                W skład Ping An Finance Center wchodzi wiele innowacyjnych rozwiązań technologicznych,\r\n                które mają na celu zwiększenie efektywności energetycznej i zrównoważoności budynku. To również centrum życia nocnego i kulturalnego,\r\n                z restauracjami, sklepami i miejscami rozrywki, co przyciąga mieszkańców i turystów. Ping An Finance Center stanowi nie tylko ikoniczny symbol Shenzhen,\r\n                ale również testament osiągnięć chińskiej architektury i biznesu na skalę światową.\r\n            </p>\r\n        </div>\r\n\r\n        <!-- Obraz z prawej strony -->\r\n        <div class=\"image-right\">\r\n            <img src=\"../img/paif2.jpg\" alt=\"Ping An Finance Center nocą\">\r\n        </div>\r\n    </div>\r\n</div>\r\n</body>\r\n</html>\r\n', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `creation_date` date NOT NULL,
  `modification_date` date DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  `net_price` decimal(10,2) NOT NULL,
  `vat` decimal(5,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `availability` tinyint(1) NOT NULL,
  `category_id` int(11) NOT NULL,
  `size` varchar(50) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `description`, `creation_date`, `modification_date`, `expiration_date`, `net_price`, `vat`, `stock`, `availability`, `category_id`, `size`, `image_url`) VALUES
(1, 'Pamiątkowy model Burj Khalifa', 'Precyzyjnie wykonany model Burj Khalifa, idealny jako dekoracja lub pamiątka z Dubaju. Wykonany z wysokiej jakości materiałów, oddający szczegóły największego budynku świata.', '2025-01-01', '2025-01-01', '2026-01-01', 100.00, 5.00, 50, 1, 1, 'Mały', 'https://www.metalearth.com/burj-khalifa'),
(2, 'Pamiątkowy model Burj Khalifa', 'Precyzyjnie wykonany model Burj Khalifa, idealny jako dekoracja lub pamiątka z Dubaju. Wykonany z wysokiej jakości materiałów, oddający szczegóły największego budynku świata.', '2025-01-01', '2025-01-01', '2026-01-01', 100.00, 5.00, 50, 1, 1, 'Mały', 'https://www.metalearth.com/burj-khalifa'),
(3, 'Pamiątkowy model Burj Khalifa', 'Precyzyjnie wykonany model Burj Khalifa, idealny jako dekoracja lub pamiątka z Dubaju. Wykonany z wysokiej jakości materiałów, oddający szczegóły największego budynku świata.', '2025-01-01', '2025-01-01', '2026-01-01', 100.00, 5.00, 50, 1, 1, 'Mały', 'https://www.metalearth.com/burj-khalifa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page_list`
--
ALTER TABLE `page_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `page_list`
--
ALTER TABLE `page_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
