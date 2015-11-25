<?php //echo $company_json; 
$dbHost = 'localhost';
$dbUsername = 'projectreview';
$dbPassword = 'projectreview';
$dbName = 'project_review';
//connect with the database
$db = new mysqli($dbHost,$dbUsername,$dbPassword,$dbName);
//get search term
$searchTerm = $_GET['term'];
//get matched data from skills table
$query = $db->query("SELECT DISTINCT  `company_name` FROM company WHERE company_name LIKE '%".$searchTerm."%' ORDER BY company_name ASC");
while ($row = $query->fetch_assoc()) {
    $data[] = $row['company_name'];
}
//return json data
echo json_encode($data);
?>