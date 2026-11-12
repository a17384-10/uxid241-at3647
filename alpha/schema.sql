-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Oct 22, 2026 at 04:28 PM
-- Server version: 8.0.44
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cookbook_db`
--
CREATE DATABASE IF NOT EXISTS `cookbook_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `cookbook_db`;

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `category` varchar(100) NOT NULL,
  `servings` int UNSIGNED NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`id`, `title`, `subtitle`, `category`, `servings`, `description`, `image`, `created_at`) VALUES
(1, 'Ancho-Orange Chicken', 'with Kale Rice & Roasted Carrots', 'Chicken', 4, 'We\'re amping up chicken breasts with a glaze of smoky ancho chile paste and fresh orange juice in this recipe. On the side, roasted carrots and lightly creamy, golden raisin-studded rice perfectly accent the sweetness of the glaze.', '../images-renamed/ancho-orange-chicken/dish.jpg', '2026-10-21 15:56:05'),
(2, 'Beef Medallions & Mushroom Sauce', 'with Mashed Potatoes', 'Beef', 2, 'In this easy recipe, inspired by steak Diane (an American restaurant classic), we\'re searing beef medallions, then using the fond in the pan to make a rich, bright mushroom sauce for spooning on top. Garlic mashed potatoes and sautéed kale make for delicious, simple sides.', '../images-renamed/beef-medallions-mushroom-sauce/dish.jpg', '2026-10-21 15:56:05'),
(3, 'Broccoli & Basil Pesto Sandwiches', 'with Romaine & Citrus Salad', 'Vegetarian', 4, 'These Italian focaccia sandwiches are layered with broccoli, three cheeses, and a savory basil, cashew, and pine nut pesto, then baked in the oven to meld all the bright, aromatic flavors. On the side, we\'re serving a refreshing salad of romaine and seasonal clementine, dressed in a creamy dressing made with fresh clementine juice.', '../images-renamed/broccoli-basil-pesto-sandwiches/dish.jpg', '2026-10-21 15:56:05'),
(4, 'Broccoli & Mozzarella Calzones', 'with Caesar Salad', 'Vegetarian', 4, 'These calzones are loaded with melty fresh mozzarella, creamy ricotta, and tender broccoli—balanced by a tangy tomato dipping sauce. For a refreshing side, we\'re tossing crunchy romaine and briny black olives in our take on Caesar dressing.', '../images-renamed/broccoli-mozzarella-calzones/dish.jpg', '2026-10-21 15:56:05'),
(5, 'Bucatini Alfredo', 'with Broccoli', 'Vegetarian', 2, 'This quick-cooking recipe captures all the deliciously creamy, rich flavor of the classic Italian-American sauce—with the welcome addition of quick-braised broccoli. A dusting of pecorino cheese completes each bowl with a touch of sharpness.', '../images-renamed/bucatini-alfredo/dish.jpg', '2026-10-21 15:56:05');

-- --------------------------------------------------------

--
-- Table structure for table `recipes_data_ver8_xlsx___recipes`
--

CREATE TABLE `recipes_data_ver8_xlsx___recipes` (
  `recipe_id` int DEFAULT NULL,
  `slug` varchar(41) DEFAULT NULL,
  `title` varchar(42) DEFAULT NULL,
  `subtitle` varchar(47) DEFAULT NULL,
  `category` varchar(14) DEFAULT NULL,
  `servings` int DEFAULT NULL,
  `description` varchar(416) DEFAULT NULL,
  `ingredient_count` int DEFAULT NULL,
  `step_count` int DEFAULT NULL,
  `main_image` varchar(57) DEFAULT NULL,
  `ingredients_image` varchar(64) DEFAULT NULL,
  `image_folder` varchar(48) DEFAULT NULL,
  `source_pdf` varchar(98) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `recipes_data_ver8_xlsx___recipes`
--

INSERT INTO `recipes_data_ver8_xlsx___recipes` (`recipe_id`, `slug`, `title`, `subtitle`, `category`, `servings`, `description`, `ingredient_count`, `step_count`, `main_image`, `ingredients_image`, `image_folder`, `source_pdf`) VALUES
(1, 'ancho-orange-chicken', 'Ancho-Orange Chicken', 'with Kale Rice & Roasted Carrots', 'Chicken', 4, 'We\'re amping up chicken breasts with a glaze of smoky ancho chile paste and fresh orange juice in this recipe. On the side, roasted carrots and lightly creamy, golden raisin-studded rice perfectly accent the sweetness of the glaze.', 11, 6, 'images/ancho-orange-chicken/dish.jpg', 'images/ancho-orange-chicken/ingredients.png', 'images/ancho-orange-chicken', 'Recipe_Ancho-Orange_Chicken_with_Kale_Rice_Roasted_Carrots.pdf'),
(2, 'beef-medallions-mushroom-sauce', 'Beef Medallions & Mushroom Sauce', 'with Mashed Potatoes', 'Beef', 2, 'In this easy recipe, inspired by steak Diane (an American restaurant classic), we\'re searing beef medallions, then using the fond in the pan to make a rich, bright mushroom sauce for spooning on top. Garlic mashed potatoes and sautéed kale make for delicious, simple sides.', 9, 6, 'images/beef-medallions-mushroom-sauce/dish.jpg', 'images/beef-medallions-mushroom-sauce/ingredients.png', 'images/beef-medallions-mushroom-sauce', 'Recipe_Beef_Medallions_Mushroom_Sauce_with_Mashed_Potatoes.pdf'),
(3, 'broccoli-basil-pesto-sandwiches', 'Broccoli & Basil Pesto Sandwiches', 'with Romaine & Citrus Salad', 'Vegetarian', 4, 'These Italian focaccia sandwiches are layered with broccoli, three cheeses, and a savory basil, cashew, and pine nut pesto, then baked in the oven to meld all the bright, aromatic flavors. On the side, we\'re serving a refreshing salad of romaine and seasonal clementine, dressed in a creamy dressing made with fresh clementine juice.', 14, 6, 'images/broccoli-basil-pesto-sandwiches/dish.jpg', 'images/broccoli-basil-pesto-sandwiches/ingredients.png', 'images/broccoli-basil-pesto-sandwiches', 'Recipe_Broccoli_Basil_Pesto_Sandwiches_with_Romaine_Citrus_Salad.pdf'),
(4, 'broccoli-mozzarella-calzones', 'Broccoli & Mozzarella Calzones', 'with Caesar Salad', 'Vegetarian', 4, 'These calzones are loaded with melty fresh mozzarella, creamy ricotta, and tender broccoli—balanced by a tangy tomato dipping sauce. For a refreshing side, we\'re tossing crunchy romaine and briny black olives in our take on Caesar dressing.', 12, 6, 'images/broccoli-mozzarella-calzones/dish.jpg', 'images/broccoli-mozzarella-calzones/ingredients.png', 'images/broccoli-mozzarella-calzones', 'Recipe_Broccoli_Mozzarella_Calzones_with_Caesar_Salad.pdf'),
(5, 'bucatini-alfredo', 'Bucatini Alfredo', 'with Broccoli', 'Vegetarian', 2, 'This quick-cooking recipe captures all the deliciously creamy, rich flavor of the classic Italian-American sauce—with the welcome addition of quick-braised broccoli. A dusting of pecorino cheese completes each bowl with a touch of sharpness.', 9, 5, 'images/bucatini-alfredo/dish.jpg', 'images/bucatini-alfredo/ingredients.png', 'images/bucatini-alfredo', 'Recipe_Bucatini_Alfredo_with_Broccoli.pdf'),
(6, 'bucatini-tomato-sauce', 'Bucatini & Tomato Sauce', 'with Roasted Broccoli', 'Vegetarian', 2, 'Made with petite datterini tomatoes, the sauce for tonight\'s bucatini highlights briny olives and capers, hot red pepper flakes, and savory Grana Padano cheese. We\'re mixing in roasted broccoli for contrasting texture and nutty-sweet flavor.', 10, 5, 'images/bucatini-tomato-sauce/dish.jpg', 'images/bucatini-tomato-sauce/ingredients.png', 'images/bucatini-tomato-sauce', 'Recipe_Bucatini_Tomato_Sauce_with_Roasted_Broccoli.pdf'),
(7, 'cheesy-enchiladas-rojas', 'Cheesy Enchiladas Rojas', 'with Mushrooms & Kale', 'Vegetarian', 4, 'Our hearty vegetarian enchiladas are filled with a combination of fragrant, Mexican-spiced rice and sautéed mushrooms and kale. For even more flavor, we\'re baking them under a smoky-sweet tomato sauce flavored with ancho chile paste and a layer of melty white cheddar. A dollop of lime-seasoned sour cream adds creamy, cooling balance. (You may receive green curly, dark green lacinato, or red kale.)', 13, 6, 'images/cheesy-enchiladas-rojas/dish.jpg', 'images/cheesy-enchiladas-rojas/ingredients.png', 'images/cheesy-enchiladas-rojas', 'Recipe_Cheesy_Enchiladas_Rojas_with_Mushrooms_Kale.pdf'),
(8, 'crispy-fish-sandwiches', 'Crispy Fish Sandwiches', 'with Tartar Sauce & Roasted Sweet Potato Wedges', 'Fish & Seafood', 4, 'These sandwiches highlight wild Alaskan pollock—flavored with aromatic seasonings, coated with panko breadcrumbs, and pan-fried for a golden-brown crust. In classic fashion, a tangy, mayo-based tartar sauce perfectly balances the fish.', 10, 6, 'images/crispy-fish-sandwiches/dish.jpg', 'images/crispy-fish-sandwiches/ingredients.png', 'images/crispy-fish-sandwiches', 'Recipe_Crispy_Fish_Sandwiches_with_Tartar_Sauce_Roasted_Sweet_Potato_Wedges.pdf'),
(9, 'general-tsos-chicken', 'General Tso\'s Chicken', 'with Bok Choy & Jasmine Rice', 'Chicken', 2, 'In this quick-cooking spin on a takeout favorite, hoisin sauce, honey, sriracha, and sesame oil lend our chicken the sweet, spicy, and nutty flavors General Tso\'s is known for. A light dusting of cornstarch on the chicken just before it hits the pan creates a delicately crispy exterior (and helps it soak up the irresistible sauce later).', 11, 5, 'images/general-tsos-chicken/dish.jpg', 'images/general-tsos-chicken/ingredients.png', 'images/general-tsos-chicken', 'Recipe_General_Tsos_Chicken_with_Bok_Choy_Jasmine_Rice.pdf'),
(10, 'hoisin-glazed-pork-chops', 'Hoisin-Glazed Pork Chops', 'with Stir-Fried Vegetables & Wonton Noodles', 'Pork', 4, 'Delightfully chewy wonton noodles tossed in a nutty, savory sauce are a delicious accompaniment to these pork chops. For depth of flavor, we\'re pan-searing the pork chops, then glazing them with barbecue-like hoisin, whose sweetness perfectly matches bites of sautéed carrots in the noodles.', 11, 6, 'images/hoisin-glazed-pork-chops/dish.jpg', 'images/hoisin-glazed-pork-chops/ingredients.png', 'images/hoisin-glazed-pork-chops', 'Recipe_HoisinGlazed_Pork_Chops_with_StirFried_Vegetables_Wonton_Noodles.pdf'),
(11, 'honey-butter-barramundi', 'Honey-Butter Barramundi', 'with Za\'atar Roasted Vegetables', 'Fish & Seafood', 4, 'This Middle Eastern recipe pairs crispy barramundi—served in a family-friendly pan sauce of honey and butter—with a medley of winter vegetables. For savory, herby flavor, we\'re seasoning the vegetables with za\'atar before roasting them.', 11, 6, 'images/honey-butter-barramundi/dish.jpg', 'images/honey-butter-barramundi/ingredients.png', 'images/honey-butter-barramundi', 'Recipe_HoneyButter_Barramundi_with_Zaatar_Roasted_Vegetables.pdf'),
(12, 'kale-ricotta-quiche', 'Kale & Ricotta Quiche', 'with Romaine, Apple, & Almond Salad', 'Vegetarian', 4, 'This crowd-pleasing quiche showcases a rich, eggy filling made with ricotta and cream —balanced by hearty sautéed kale. On the side, we\'re serving a refreshing salad of crisp romaine and apple, wrapped in a creamy lemon dressing.', 13, 6, 'images/kale-ricotta-quiche/dish.jpg', 'images/kale-ricotta-quiche/ingredients.png', 'images/kale-ricotta-quiche', 'Recipe_Kale_Ricotta_Quiche_with_Romaine,_Apple,_Almond_Salad.pdf'),
(13, 'mexican-spiced-barramundi', 'Mexican-Spiced Barramundi', 'with Kale, Sweet Potato, & Avocado Salad', 'Fish & Seafood', 2, 'This recipe has been approved by Whole30®. To learn more about their guidelines, visit Whole30.com. We\'re partnering with Whole30® to bring you the first of eight weeks of delicious recipes. Zesty spiced barramundi is the perfect partner for a salad of roasted sweet potato and kale, marinated in a creamy avocado and citrus dressing to soften the leaves.', 9, 6, 'images/mexican-spiced-barramundi/dish.jpg', 'images/mexican-spiced-barramundi/ingredients.png', 'images/mexican-spiced-barramundi', 'Recipe_MexicanSpiced_Barramundi_with_Kale_Sweet_Potato_Avocado_Salad.pdf'),
(14, 'mushroom-potato-tacos', 'Mushroom & Potato Tacos', 'with Romaine & Orange Salad', 'Vegetarian', 2, 'For this hearty vegetarian meal, we\'re filling soft flour tortillas with mushrooms and potato—seasoned with a zesty, chorizo-inspired blend, then roasted. A pickled pepper relish lends bright flavor to the tacos, all tied together with a creamy sauce seasoned with the same spices. Our side salad of juicy orange and crunchy romaine rounds out the dish.', 13, 6, 'images/mushroom-potato-tacos/dish.jpg', 'images/mushroom-potato-tacos/ingredients.png', 'images/mushroom-potato-tacos', 'Recipe_Mushroom_Potato_Tacos_with_Romaine_Orange_Salad.pdf'),
(15, 'parmesan-crusted-chicken', 'Parmesan-Crusted Chicken', 'with Mashed Sweet Potatoes & Roasted Broccoli', 'Chicken', 4, 'In this simple, seasonal recipe, you\'ll coat chicken in a combination of flour, parmesan cheese, and savory spices before pan-searing it. We\'re adding more of the same spices to a bright, creamy sauce, perfect for spooning over the chicken and broccoli.', 9, 6, 'images/parmesan-crusted-chicken/dish.jpg', 'images/parmesan-crusted-chicken/ingredients.png', 'images/parmesan-crusted-chicken', 'Recipe_ParmesanCrusted_Chicken_with_Mashed_Sweet_Potatoes_Roasted_Broccoli.pdf'),
(16, 'pimento-cheeseburgers', 'Pimento Cheeseburgers', 'with Sweet Potato Oven Fries', 'Beef', 2, 'Tonight, the classic cheeseburger gets an easy, Southern-style lift from pimento cheese —a zesty spread made with cheddar, mayo, pickled peppers, and spices. We\'re serving our burgers with sweet potato oven fries for a flavorful, seasonal twist on the usual side.', 7, 6, 'images/pimento-cheeseburgers/dish.jpg', 'images/pimento-cheeseburgers/ingredients.png', 'images/pimento-cheeseburgers', 'Recipe_Pimento_Cheeseburgers_with_Sweet_Potato_Oven_Fries.pdf'),
(17, 'pork-chorizo-tacos', 'Pork Chorizo Tacos', 'with Cheesy Roasted Potatoes', 'Pork', 2, 'These tacos get plenty of bold flavor from ground chorizo (a type of spiced pork sausage), cooked into a delightfully saucy filling with cabbage and fresh citrus juices. On the side, we\'re livening up roasted potatoes with garlic and Cotija cheese.', 10, 6, 'images/pork-chorizo-tacos/dish.jpg', 'images/pork-chorizo-tacos/ingredients.png', 'images/pork-chorizo-tacos', 'Recipe_Pork_Chorizo_Tacos_with_Cheesy_Roasted_Potatoes.pdf'),
(18, 'roasted-broccoli-fregola-sarda-salad', 'Roasted Broccoli & Fregola Sarda Salad', 'with Hard-Boiled Eggs & Tahini Dressing', 'Vegetarian', 2, 'This Middle Eastern-inspired recipe is brimming with varied flavors and textures. Toasty pearls of pasta, roasted vegetables (seasoned with savory, herby za\'atar), crumbled cheese, and chopped almonds all come together in a smooth, nutty dressing.', 11, 6, 'images/roasted-broccoli-fregola-sarda-salad/dish.jpg', 'images/roasted-broccoli-fregola-sarda-salad/ingredients.png', 'images/roasted-broccoli-fregola-sarda-salad', 'Recipe_Roasted_Broccoli_Fregola_Sarda_Salad_with_HardBoiled_Eggs_Tahini_Dressing.pdf'),
(19, 'roasted-brussels-sprout-freekeh-salad', 'Roasted Brussels Sprout & Freekeh Salad', 'with Lemon Yogurt & Barrel-Aged Feta', 'Vegetarian', 2, 'This Mediterranean-inspired grain salad is brimming with varied, vibrant flavors. Nutty freekeh and roasted Brussels sprouts get pops of sweetness from pickled peppers and dates, balanced by briny crumbled Feta. To dollop on top, we\'re serving lemon-seasoned yogurt for extra brightness.', 12, 6, 'images/roasted-brussels-sprout-freekeh-salad/dish.jpg', 'images/roasted-brussels-sprout-freekeh-salad/ingredients.png', 'images/roasted-brussels-sprout-freekeh-salad', 'Recipe_Roasted_Brussels_Sprout_Freekeh_Salad_with_Lemon_Yogurt_Barrel-Aged_Feta.pdf'),
(20, 'roasted-cauliflower-salad', 'Roasted Cauliflower Salad', 'with Caper Brown Butter & Parmesan Breadcrumbs', 'Vegetarian', 2, 'Seasonal salads don\'t get much more satisfying than this. We\'re bringing roasted cauliflower and sautéed kale together with cheesy toasted breadcrumbs and a briny caper-studded dressing. Served on top, soft-boiled eggs add extra richness.', 10, 6, 'images/roasted-cauliflower-salad/dish.jpg', 'images/roasted-cauliflower-salad/ingredients.png', 'images/roasted-cauliflower-salad', 'Recipe_Roasted_Cauliflower_Salad_with_Caper_Brown_Butter_Parmesan_Breadcrumbs.pdf'),
(21, 'roasted-chicken-fall-vegetables', 'Roasted Chicken & Fall Vegetables', 'with Cranberry & Ginger Compote', 'Chicken', 4, 'For this comforting autumn dinner, we\'re seasoning half chickens with the classic flavors of garlic, onion, and smoked paprika, then roasting them along with sweet potatoes and Brussels sprouts. The rich chicken finds delicious contrast in a tart-sweet compote, made simply by cooking fresh cranberries and ginger with a bit of sugar and water.', 9, 6, 'images/roasted-chicken-fall-vegetables/dish.jpg', 'images/roasted-chicken-fall-vegetables/ingredients.png', 'images/roasted-chicken-fall-vegetables', 'Recipe_Roasted_Chicken_Fall_Vegetables_with_Cranberry_Ginger_Compote.pdf'),
(22, 'roasted-pork-broccoli', 'Roasted Pork & Broccoli', 'with Apple, Cheese Sauce, & Garlic Breadcrumbs', 'Pork', 2, 'To elevate the classic savory-sweet pairing, we\'re topping roasted pork with sautéed apple in this crowd-pleasing recipe. The pork and a side of broccoli, roasted on the same sheet pan, come together with a rich, warming fontina cheese sauce.', 10, 6, 'images/roasted-pork-broccoli/dish.jpg', 'images/roasted-pork-broccoli/ingredients.png', 'images/roasted-pork-broccoli', 'Recipe_Roasted_Pork_Broccoli_with_Apple,_Cheese_Sauce,_Garlic_Breadcrumbs.pdf'),
(23, 'roasted-red-pepper-pasta', 'Roasted Red Pepper Pasta', 'with Lemon-Parmesan Broccoli', 'Vegetarian', 2, 'In this quick-cooking recipe, whole grain pipe rigate gets pops of flavor from sweet roasted piquillo peppers and briny capers—plus a layer of exciting crunch from almonds. It all comes together in a creamy, mildly spicy sauce.', 12, 5, 'images/roasted-red-pepper-pasta/dish.jpg', 'images/roasted-red-pepper-pasta/ingredients.png', 'images/roasted-red-pepper-pasta', 'Recipe_Roasted_Red_Pepper_Pasta_with_LemonParmesan_Broccoli.pdf'),
(24, 'roasted-squash-curry', 'Roasted Squash Curry', 'with Crispy Mung Beans & Jasmine Rice', 'Vegetarian', 2, 'In this recipe, veggie curry gets a unique lift from spaghetti squash—oven-roasted, then broken into pasta-like strands with a fork. We\'re finishing our squash and bok choy in a sauce made with fresh aromatics and two well-balanced pantry ingredients: spicy yellow curry paste and cooling coconut milk. A garnish of dried mung beans brings it all together with exciting crunch.', 12, 6, 'images/roasted-squash-curry/dish.jpg', 'images/roasted-squash-curry/ingredients.png', 'images/roasted-squash-curry', 'Recipe_Roasted_Squash_Curry_with_Crispy_Mung_Beans_Jasmine_Rice.pdf'),
(25, 'roasted-turkey-breast-farro-endive-salad', 'Roasted Turkey Breast & Farro-Endive Salad', 'with Brown Butter Apple Compote', 'Turkey', 2, 'Fall comfort food gets a delicious lift in this recipe. A sweet, toasty compote (simply apple and shallot cooked in brown butter) balances our savory roasted turkey breast. On the side, we\'re tossing warm grains with endive—first cooked with a bit of honey and lemon to brighten its mildly bitter flavor.', 10, 6, 'images/roasted-turkey-breast-farro-endive-salad/dish.jpg', 'images/roasted-turkey-breast-farro-endive-salad/ingredients.png', 'images/roasted-turkey-breast-farro-endive-salad', 'Recipe_Roasted_Turkey_Breast_FarroEndive_Salad_with_Brown_Butter_Apple_Compote.pdf'),
(26, 'salmon-honey-glazed-carrots', 'Salmon & Honey-Glazed Carrots', 'with Lemon-Saffron Yogurt Sauce', 'Fish & Seafood', 2, 'This elegant dish gets unique flavor from a prized spice, saffron, used two ways: added to the water used to boil the potatoes and stirred into a creamy yogurt sauce. The bright sauce is delicious spooned over rich salmon, potatoes, and carrots—which get another flavor-packed lift from a glaze of honey and fragrant cumin. Aleppo pepper adds just a hint of spice throughout the dish, balanced by cooling fresh mint.', 11, 6, 'images/salmon-honey-glazed-carrots/dish.jpg', 'images/salmon-honey-glazed-carrots/ingredients.png', 'images/salmon-honey-glazed-carrots', 'Recipe_Salmon_HoneyGlazed_Carrots_with_LemonSaffron_Yogurt_Sauce.pdf'),
(27, 'seared-chicken-mashed-potatoes', 'Seared Chicken & Mashed Potatoes', 'with Maple-Glazed Carrots', 'Chicken', 2, 'We\'re giving seared chicken a lift with a rich pan sauce, made with sweet maple syrup and tangy sherry vinegar. It\'s the perfect accompaniment for creamy mashed potatoes and roasted carrots, dressed with a bit more maple syrup.', 7, 6, 'images/seared-chicken-mashed-potatoes/dish.jpg', 'images/seared-chicken-mashed-potatoes/ingredients.png', 'images/seared-chicken-mashed-potatoes', 'Recipe_Seared_Chicken_Mashed_Potatoes_with_MapleGlazed_Carrots.pdf'),
(28, 'seared-steaks-garlic-butter', 'Seared Steaks & Garlic Butter', 'with Oven Fries', 'Beef', 4, '\"Steak frites,\" or steak with french fries, is classic French bistro fare. Tonight\'s steaks get another layer of rich flavor from garlic butter, spooned over them as they cook. Creamy mustard sauce is a perfect match for the rich steaks and hearty oven-roasted fries, while a simple salad adds refreshing contrast. (You may receive crisp romaine or tender butter lettuce.)', 8, 6, 'images/seared-steaks-garlic-butter/dish.jpg', 'images/seared-steaks-garlic-butter/ingredients.png', 'images/seared-steaks-garlic-butter', 'Recipe_Seared_Steaks_Garlic_Butter_with_Oven_Fries.pdf'),
(29, 'shiitake-hoisin-beef-burgers', 'Shiitake & Hoisin Beef Burgers', 'with Miso Mayonnaise & Roasted Sweet Potatoes', 'Beef', 4, 'These Asian-inspired burgers get their irresistible umami flavor from chopped shiitake mushrooms (mixed right into the beef) and a miso-mayo spread. Piled on top, crisp ribbons of bok choy round out the burgers, served with a side of roasted sweet potato wedges.', 10, 6, 'images/shiitake-hoisin-beef-burgers/dish.jpg', 'images/shiitake-hoisin-beef-burgers/ingredients.png', 'images/shiitake-hoisin-beef-burgers', 'Recipe_Shiitake_Hoisin_Beef_Burgers_with_Miso_Mayonnaise_Roasted_Sweet_Potatoes.pdf'),
(30, 'shrimp-fra-diavolo', 'Shrimp Fra Diavolo', 'with Lumaca Rigata Pasta', 'Fish & Seafood', 2, 'Tonight\'s variation on the beloved Italian-American dish gets its \"devilish\" heat from Calabrian chile paste, mixed into a tangy-sweet tomato sauce. It perfectly coats shrimp, cabbage, and lumaca rigata pasta. A garnish of sliced almonds finishes the dish with contrasting crunch.', 9, 6, 'images/shrimp-fra-diavolo/dish.jpg', 'images/shrimp-fra-diavolo/ingredients.png', 'images/shrimp-fra-diavolo', 'Recipe_Shrimp_Fra_Diavolo_with_Lumaca_Rigata_Pasta.pdf'),
(31, 'smoked-gouda-mushroom-flatbread', 'Smoked Gouda & Mushroom Flatbread', 'with Endive & Apple Salad', 'Vegetarian', 2, 'For this rustic seasonal meal, we\'re topping flatbread—made by rolling out pizza dough until extra-thin—with two kinds of cheeses, including nutty smoked Gouda. Cremini mushrooms add even more irresistibly savory flavor to the flatbread, balanced by a bright, crisp endive and apple salad.', 11, 6, 'images/smoked-gouda-mushroom-flatbread/dish.jpg', 'images/smoked-gouda-mushroom-flatbread/ingredients.png', 'images/smoked-gouda-mushroom-flatbread', 'Recipe_Smoked_Gouda_Mushroom_Flatbread_with_Endive_Apple_Salad.pdf'),
(32, 'spicy-chicken-quesadillas', 'Spicy Chicken Quesadillas', 'with Beet & Orange Salad', 'Chicken', 2, 'A seasonal salad of striped Chioggia beet, juicy orange, and peanuts is a fresh pairing for these zesty quesadillas. We\'re seasoning the chicken filling with both jalapeño pepper and Mexican spices—balanced by a layer of melty white cheddar. Mexican crema brightened up with lime juice is perfect for dipping.', 11, 6, 'images/spicy-chicken-quesadillas/dish.jpg', 'images/spicy-chicken-quesadillas/ingredients.png', 'images/spicy-chicken-quesadillas', 'Recipe_Spicy_Chicken_Quesadillas_with_Beet_Orange_Salad.pdf'),
(33, 'spicy-pork-korean-rice-cakes', 'Spicy Pork & Korean Rice Cakes', 'with Bok Choy', 'Pork', 4, 'In this crowd-pleasing recipe, a savory and spicy sauce (balanced by a touch of cooling crème fraîche) brings together ground pork, bok choy, and aromatics. We\'re mixing in delightfully chewy tteok, or rice cakes—a staple of Korean cuisine.', 10, 6, 'images/spicy-pork-korean-rice-cakes/dish.jpg', 'images/spicy-pork-korean-rice-cakes/ingredients.png', 'images/spicy-pork-korean-rice-cakes', 'Recipe_Spicy_Pork_Korean_Rice_Cakes_with_Bok_Choy.pdf'),
(34, 'sweet-sour-vegetable-stir-fry', 'Sweet & Sour Vegetable Stir-Fry', 'with Fried Eggs & Peanuts', 'Vegetarian', 2, 'Two kinds of citrus—seasonal orange and lemon—give the sauce for our stir-fried vegetables its irresistible sweet-sour balance. The carrots, celery, and bok choy perfectly contrast a rich fried egg and fluffy, radish-studded white rice.', 14, 6, 'images/sweet-sour-vegetable-stir-fry/dish.jpg', 'images/sweet-sour-vegetable-stir-fry/ingredients.png', 'images/sweet-sour-vegetable-stir-fry', 'Recipe_Sweet_Sour_Vegetable_StirFry_with_Fried_Eggs_Peanuts.pdf'),
(35, 'thai-curry-chicken', 'Thai Curry Chicken', 'with Carrots & Bok Choy', 'Chicken', 2, 'In tonight\'s dish, the spicy and aromatic flavors of yellow curry paste—a Thai staple— shine through a lightly sweet coconut milk broth. Sautéed chicken, carrots, and bok choy give the curry plenty of hearty texture, while fluffy rice eagerly soaks up all the complex flavors. (Chefs, this curry paste packs a punch of heat, so be sure to use only as much as you\'d like!)', 9, 5, 'images/thai-curry-chicken/dish.jpg', 'images/thai-curry-chicken/ingredients.png', 'images/thai-curry-chicken', 'Recipe_Thai_Curry_Chicken_with_Carrots_Bok_Choy.pdf'),
(36, 'tilapia-black-lentil-salad', 'Tilapia & Black Lentil Salad', 'with Lemon Pan Sauce', 'Fish & Seafood', 2, 'In this dish, we\'re putting a twist on Italian gremolata: adding pickled peppers to the classic parsley, garlic, and lemon condiment. The bright, tangy flavors perk up a hearty salad of black lentils and roasted broccoli. We\'re also using lemon juice as the base for an easy pan sauce to serve over our seared tilapia.', 9, 6, 'images/tilapia-black-lentil-salad/dish.jpg', 'images/tilapia-black-lentil-salad/ingredients.png', 'images/tilapia-black-lentil-salad', 'Recipe_Tilapia_Black_Lentil_Salad_with_Lemon_Pan_Sauce.pdf'),
(37, 'togarashi-chicken-lettuce-cups', 'Togarashi Chicken Lettuce Cups', 'with Orange & Radishes', 'Chicken', 2, 'This recipe has been approved by Whole30®. To learn more about their guidelines, visit Whole30.com. We\'re partnering with Whole30® to bring you the first of eight weeks of delicious recipes. These chicken lettuce cups get their dynamic flavor from togarashi seasoning—a staple of Japanese cuisine. Juicy bites of orange add more bright flavor and color.', 15, 5, 'images/togarashi-chicken-lettuce-cups/dish.jpg', 'images/togarashi-chicken-lettuce-cups/ingredients.png', 'images/togarashi-chicken-lettuce-cups', 'Recipe_Togarashi_Chicken_Lettuce_Cups_with_Orange_Radishes.pdf'),
(38, 'top-chef-ginger-marinated-grassfed-steaks', 'Top Chef Ginger-Marinated Grassfed Steaks', 'with Stir-Fried Vegetables & Jasmine Rice', 'Beef', 2, 'In this recipe—inspired by our Quickfire Challenge from Top Chef Season 15 on Bravo—we\'re marinating grassfed steaks in fresh ginger, soy sauce, and citrusy ponzu sauce. The extra marinade transforms into an easy pan sauce, which adds punchy flavor to the steaks and a side of jasmine rice.', 12, 6, 'images/top-chef-ginger-marinated-grassfed-steaks/dish.jpg', 'images/top-chef-ginger-marinated-grassfed-steaks/ingredients.png', 'images/top-chef-ginger-marinated-grassfed-steaks', 'Recipe_Top_Chef_Ginger-Marinated_Grassfed_Steaks_with_Stir-Fried_Vegetables_Jasmine_RiceBlue_A.pdf'),
(39, 'top-chef-seared-grassfed-steaks', 'Top Chef Seared Grassfed Steaks', 'with Sweet Chili-Glazed Vegetables', 'Beef', 4, 'In this recipe, inspired by our Quickfire Challenge from Top Chef Season 15 on Bravo, simple grassfed steaks and rice get a sweet, tart, and spicy lift from glazed mushrooms and bok choy. Sliced radishes, softened a bit with lime juice, finish the dish off with subtle crunch.', 12, 6, 'images/top-chef-seared-grassfed-steaks/dish.jpg', 'images/top-chef-seared-grassfed-steaks/ingredients.png', 'images/top-chef-seared-grassfed-steaks', 'Recipe_Top_Chef_Seared_Grassfed_Steaks_with_Sweet_Chili-Glazed_Vegetables.pdf'),
(40, 'tuscan-chicken-green-lentil-stew', 'Tuscan Chicken & Green Lentil Stew', 'with Goat Cheese', 'Chicken', 2, 'In this comforting cold-weather recipe, we\'re serving Tuscan-spiced chicken over tender green lentils and vegetables cooked in a light, savory tomato broth. Capers and crushed red pepper add briny flavor and a touch of heat to cut through the rich, earthy stew. (Chefs, rinsing the lentils after cooking removes excess starch, resulting in a more delicate flavor.)', 12, 6, 'images/tuscan-chicken-green-lentil-stew/dish.jpg', 'images/tuscan-chicken-green-lentil-stew/ingredients.png', 'images/tuscan-chicken-green-lentil-stew', 'Recipe_Tuscan_Chicken_Green_Lentil_Stew_with_Goat_Cheese.pdf');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- Table structure for table `users`
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(100) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- default admin user
INSERT INTO `users` (`username`, `password_hash`) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');