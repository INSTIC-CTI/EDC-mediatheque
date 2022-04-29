<?php

namespace App\Helper;


class YouMayAlsoLikeManager
{
    public function displayBooksFromType($book, $types) : ?array
    {

        //Add in array all books from same type of actual book
        $booksFromTypes =[];
        foreach($book->getType() as $type){
            foreach($type->getBooks() as $bookFromTypes){
                $booksFromTypes[] = $bookFromTypes;
            }
        }

        //Remove duplicate books in array
        $booksFromTypes = array_unique($booksFromTypes);

        //Remove from array the actual book
        $key = array_search($book, $booksFromTypes);
        unset($booksFromTypes[$key]);

        //Shuffle all items to make the display random
        shuffle($booksFromTypes);

        //Limit result of 4 books to display
        return array_slice($booksFromTypes, 0, 3);

    }
};