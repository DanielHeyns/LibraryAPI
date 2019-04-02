#!/bin/bash
php artisan tinker

//#note: when in doubt/need help with an error, just write 'wtf -a'

//#function csvToArray($filename = '', $delimiter = ',')
//#use your own path before
$filename = './SENG401-Lab4-Books-cleaned.csv';
$delimiter = ',';

if (!file_exists($filename) || !is_readable($filename))\
  echo "error";

//#run up till here to check you have the right file path
//#if there is no "error" echo-ed, then you have the right path for the csv


$header = null;
$data = array();
if (($handle = fopen($filename, 'r')) !== false)\
{
    while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
    {
        if (!$header)
            $header = $row;
        else
            $data[] = array_combine($header, $row);
    }
    fclose($handle);
}

$csvArr = $data;
//#run up till here to check you have gotten the csv as an array
//#you should see the csv records as an array

foreach($csvArr as $record){\
  $book = new App\Book;
  $book->name = $record['Name'];
  $book->ISBN = $record['ISBN'];
  $book->pub_year = $record['Year'];
  $book->pub = $record['Publisher'];
  $book->image_path = $record['Image'];
  $book->author = $record['Authors'];
  $book->save();
}

//#run up till here then run these to populate Authors
//#note this only works because each book only has 1 author at the moment

foreach($csvArr as $record){\
  $author = new App\Author;
  $author->name = $record['Authors'];
  $author->save();
}
