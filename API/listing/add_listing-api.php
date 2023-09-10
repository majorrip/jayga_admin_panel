<?php

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle database connection
$host = 'podma-bd-cp1';
$username = 'jaygabdc_atif_admin';
$password = 'jaygabd_atif_123';
$dbname = 'jaygabdc_jayga_db_1';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle database connection error
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(array('error' => 'Internal Server Error'));
    die();
}

// Function to insert listing information
function insertListingInformation() {
    global $conn; // Declare $conn as a global variable inside the function

    // Check if the required parameters are provided
    $requiredFields = array(
        'lister_id',
        'lister_name',
        'nid_number',
        'guest_num',
        'bed_num',
        'bathroom_num',
        'listing_title',
        'listing_description',
        'full_day_price_set_by_user',
        'listing_address',
        'zip_code',
        'district',
        'town',
        'allow_short_stay',
        'describe_peaceful',
        'describe_unique',
        'describe_familyfriendly',
        'describe_stylish',
        'describe_central',
        'describe_spacious',
        'listing_type',
        'lati',
        'longi'
    );

    foreach ($requiredFields as $field) {
        if (!isset($_POST[$field])) {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(array('error' => 'Missing required fields'));
            die();
        }
    }

    // Retrieve parameters
    $lister_id = $_POST['lister_id'];
    $lister_name = $_POST['lister_name'];
    $nid_number = $_POST['nid_number'];
    $guest_num = $_POST['guest_num'];
    $bed_num = $_POST['bed_num'];
    $bathroom_num = $_POST['bathroom_num'];
    $listing_title = $_POST['listing_title'];
    $listing_description = $_POST['listing_description'];
    $full_day_price_set_by_user = $_POST['full_day_price_set_by_user'];
    $listing_address = $_POST['listing_address'];
    $zip_code = $_POST['zip_code'];
    $district = $_POST['district'];
    $town = $_POST['town'];
    $allow_short_stay = $_POST['allow_short_stay'];
    $describe_peaceful = $_POST['describe_peaceful'];
    $describe_unique = $_POST['describe_unique'];
    $describe_familyfriendly = $_POST['describe_familyfriendly'];
    $describe_stylish = $_POST['describe_stylish'];
    $describe_central = $_POST['describe_central'];
    $describe_spacious = $_POST['describe_spacious'];
    $listing_type = $_POST['listing_type'];
    $lati = $_POST['lati'];
    $longi = $_POST['longi'];

    // Insert data into the 'listing' table
    $sql = "INSERT INTO listing (lister_id, lister_name, nid_number,guest_num, bed_num, bathroom_num, listing_title, listing_description, full_day_price_set_by_user, listing_address, zip_code, district, town, allow_short_stay, describe_peaceful, describe_unique, describe_familyfriendly, describe_stylish, describe_central, describe_spacious, listing_type, lati, longi)
    VALUES (:lister_id, :lister_name, :nid_number, :guest_num, :bed_num, :bathroom_num, :listing_title, :listing_description, :full_day_price_set_by_user, :listing_address, :zip_code, :district, :town, :allow_short_stay, :describe_peaceful, :describe_unique, :describe_familyfriendly, :describe_stylish, :describe_central, :describe_spacious, :listing_type, :lati, :longi)";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':lister_id', $lister_id, PDO::PARAM_INT);
    $stmt->bindParam(':lister_name', $lister_name, PDO::PARAM_STR);
    $stmt->bindParam(':nid_number', $nid_number, PDO::PARAM_STR);
    $stmt->bindParam(':guest_num', $guest_num, PDO::PARAM_INT);
    $stmt->bindParam(':bed_num', $bed_num, PDO::PARAM_INT);
    $stmt->bindParam(':bathroom_num', $bathroom_num, PDO::PARAM_INT);
    $stmt->bindParam(':listing_title', $listing_title, PDO::PARAM_STR);
    $stmt->bindParam(':listing_description', $listing_description, PDO::PARAM_STR);
    $stmt->bindParam(':full_day_price_set_by_user', $full_day_price_set_by_user, PDO::PARAM_STR);
    $stmt->bindParam(':listing_address', $listing_address, PDO::PARAM_STR);
    $stmt->bindParam(':zip_code', $zip_code, PDO::PARAM_STR);
    $stmt->bindParam(':district', $district, PDO::PARAM_STR);
    $stmt->bindParam(':town', $town, PDO::PARAM_STR);
    $stmt->bindParam(':allow_short_stay', $allow_short_stay, PDO::PARAM_INT);
    $stmt->bindParam(':describe_peaceful', $describe_peaceful, PDO::PARAM_INT);
    $stmt->bindParam(':describe_unique', $describe_unique, PDO::PARAM_INT);
    $stmt->bindParam(':describe_familyfriendly', $describe_familyfriendly, PDO::PARAM_INT);
    $stmt->bindParam(':describe_stylish', $describe_stylish, PDO::PARAM_INT);
    $stmt->bindParam(':describe_central', $describe_central, PDO::PARAM_INT);
    $stmt->bindParam(':describe_spacious', $describe_spacious, PDO::PARAM_INT);
    $stmt->bindParam(':listing_type', $listing_type, PDO::PARAM_STR);
    $stmt->bindParam(':lati', $lati, PDO::PARAM_STR);
    $stmt->bindParam(':longi', $longi, PDO::PARAM_STR);

    try {
        $stmt->execute();
        $listing_id = $conn->lastInsertId(); // Get the generated listing_id
        
        // Handle data for the 'listing_describe' table
        $appartments = isset($_POST['appartments']) ? $_POST['appartments'] : 0;
        $cabin = isset($_POST['cabin']) ? $_POST['cabin'] : 0;
        $lounge = isset($_POST['lounge']) ? $_POST['lounge'] : 0;
        $farm = isset($_POST['farm']) ? $_POST['farm'] : 0;
        $campsite = isset($_POST['campsite']) ? $_POST['campsite'] : 0;
        $hotel = isset($_POST['hotel']) ? $_POST['hotel'] : 0;
        $bread_breakfast = isset($_POST['bread_breakfast']) ? $_POST['bread_breakfast'] : 0;

        // Insert data into the 'listing_describe' table
        $describeSql = "INSERT INTO listing_describe (listing_id, appartments, cabin, lounge, farm, campsite, hotel, bread_breakfast)
        VALUES (:listing_id, :appartments, :cabin, :lounge, :farm, :campsite, :hotel, :bread_breakfast)";

        $describeStmt = $conn->prepare($describeSql);
        $describeStmt->bindParam(':listing_id', $listing_id, PDO::PARAM_INT);
        $describeStmt->bindParam(':appartments', $appartments, PDO::PARAM_INT);
        $describeStmt->bindParam(':cabin', $cabin, PDO::PARAM_INT);
        $describeStmt->bindParam(':lounge', $lounge, PDO::PARAM_INT);
        $describeStmt->bindParam(':farm', $farm, PDO::PARAM_INT);
        $describeStmt->bindParam(':campsite', $campsite, PDO::PARAM_INT);
        $describeStmt->bindParam(':hotel', $hotel, PDO::PARAM_INT);
        $describeStmt->bindParam(':bread_breakfast', $bread_breakfast, PDO::PARAM_INT);

        $describeStmt->execute();

        // Handle data for the 'listing_guest_amenities' table
        $wifi = isset($_POST['wifi']) ? $_POST['wifi'] : 0;
        $tv = isset($_POST['tv']) ? $_POST['tv'] : 0;
        $kitchen = isset($_POST['kitchen']) ? $_POST['kitchen'] : 0;
        $washing_machine = isset($_POST['washing_machine']) ? $_POST['washing_machine'] : 0;
        $free_parking = isset($_POST['free_parking']) ? $_POST['free_parking'] : 0;
        $breakfast_included = isset($_POST['breakfast_included']) ? $_POST['breakfast_included'] : 0;
        $air_condition = isset($_POST['air_condition']) ? $_POST['air_condition'] : 0;
        $dedicated_workspace = isset($_POST['dedicated_workspace']) ? $_POST['dedicated_workspace'] : 0;
        $pool = isset($_POST['pool']) ? $_POST['pool'] : 0;
        $hot_tub = isset($_POST['hot_tub']) ? $_POST['hot_tub'] : 0;
        $patio = isset($_POST['patio']) ? $_POST['patio'] : 0;
        $bbq_grill = isset($_POST['bbq_grill']) ? $_POST['bbq_grill'] : 0;
        $fire_pit = isset($_POST['fire_pit']) ? $_POST['fire_pit'] : 0;
        $gym = isset($_POST['gym']) ? $_POST['gym'] : 0;
        $beach_lake_access = isset($_POST['beach_lake_access']) ? $_POST['beach_lake_access'] : 0;
        $smoke_alarm = isset($_POST['smoke_alarm']) ? $_POST['smoke_alarm'] : 0;
        $first_aid = isset($_POST['first_aid']) ? $_POST['first_aid'] : 0;
        $fire_extinguish = isset($_POST['fire_extinguish']) ? $_POST['fire_extinguish'] : 0;
        $cctv = isset($_POST['cctv']) ? $_POST['cctv'] : 0;


        // Insert data into the 'listing_guest_amenities' table
        $amenitiesSql = "INSERT INTO listing_guest_amenities (listing_id, wifi, tv, kitchen, washing_machine, free_parking, breakfast_included, air_condition, dedicated_workspace, pool, hot_tub, patio, bbq_grill, fire_pit, gym, beach_lake_access, smoke_alarm, first_aid, fire_extinguish, cctv)
        VALUES (:listing_id, :wifi, :tv, :kitchen, :washing_machine, :free_parking, :breakfast_included, :air_condition, :dedicated_workspace, :pool, :hot_tub, :patio, :bbq_grill, :fire_pit, :gym, :beach_lake_access, :smoke_alarm, :first_aid, :fire_extinguish, :cctv)";
        
        $amenitiesStmt = $conn->prepare($amenitiesSql);
        $amenitiesStmt->bindParam(':listing_id', $listing_id, PDO::PARAM_INT);
        $amenitiesStmt->bindParam(':wifi', $wifi, PDO::PARAM_INT);
        $amenitiesStmt->bindParam(':tv', $tv, PDO::PARAM_INT);
        $amenitiesStmt->bindParam(':kitchen', $kitchen, PDO::PARAM_INT);
        $amenitiesStmt->bindParam(':washing_machine', $washing_machine, PDO::PARAM_INT);
        $amenitiesStmt->bindParam(':free_parking', $free_parking, PDO::PARAM_INT);
        $amenitiesStmt->bindParam(':breakfast_included', $breakfast_included, PDO::PARAM_INT);
        $amenitiesStmt->bindParam(':air_condition', $air_condition, PDO::PARAM_INT);
        $amenitiesStmt->bindParam(':dedicated_workspace', $dedicated_workspace, PDO::PARAM_INT);
        $amenitiesStmt->bindParam(':pool', $pool, PDO::PARAM_INT);
        $amenitiesStmt->bindParam(':hot_tub', $hot_tub, PDO::PARAM_INT);
        $amenitiesStmt->bindParam(':patio', $patio, PDO::PARAM_INT);
        $amenitiesStmt->bindParam(':bbq_grill', $bbq_grill, PDO::PARAM_INT);
        $amenitiesStmt->bindParam(':fire_pit', $fire_pit, PDO::PARAM_INT);
        $amenitiesStmt->bindParam(':gym', $gym, PDO::PARAM_INT);
        $amenitiesStmt->bindParam(':beach_lake_access', $beach_lake_access, PDO::PARAM_INT);
        $amenitiesStmt->bindParam(':smoke_alarm', $smoke_alarm, PDO::PARAM_INT);
        $amenitiesStmt->bindParam(':first_aid', $first_aid, PDO::PARAM_INT);
        $amenitiesStmt->bindParam(':fire_extinguish', $fire_extinguish, PDO::PARAM_INT);
        $amenitiesStmt->bindParam(':cctv', $cctv, PDO::PARAM_INT);
        $amenitiesStmt->execute();

        echo json_encode($responseData = array(
            'success' => 'Data inserted successfully.',
            'data' => array(
                'listing_id' => $listing_id,
                'lister_id' => $lister_id,
                'lister_name' => $lister_name,
                'nid_number' => $nid_number,
                'guest_num' => $guest_num,
                'bed_num' => $bed_num,
                'bathroom_num' => $bathroom_num,
                'listing_title' => $listing_title,
                'listing_description' => $listing_description,
                'full_day_price_set_by_user' => $full_day_price_set_by_user,
                'listing_address' => $listing_address,
                'zip_code' => $zip_code,
                'district' => $district,
                'town' => $town,
                'allow_short_stay' => $allow_short_stay,
                'describe_peaceful' => $describe_peaceful,
                'describe_unique' => $describe_unique,
                'describe_familyfriendly' => $describe_familyfriendly,
                'describe_stylish' => $describe_stylish,
                'describe_central' => $describe_central,
                'describe_spacious' => $describe_spacious,
                'listing_type' => $listing_type,
                'lati' => $lati,
                'longi' => $longi,
                // Add other data fields here as needed
            )
        ));
    } catch (PDOException $e) {
        // Handle database connection error or query error
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(array('error' => 'Query Execution Error: ' . $e->getMessage()));
    }
}

// Handle RESTful API routing
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    insertListingInformation();
} else {
    header('HTTP/1.1 404 Not Found');
    echo json_encode(array('error' => 'Not Found'));
}

?>
