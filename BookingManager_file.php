<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;


final class BookingManagerClass
{
    public function addRoom(array $roomsList, array $room) : bool
    {
        if(is_int($room[0]) && !array_search($room[0], $roomsList) && ($room[1] == "Standard" || $room[1] == "VIP")) return true;
        else return false;
    }

    public function bookRoom(array $bookingList, array $roomsList, array $wantedRoom, string $wantedCheckIn, string $wantedCheckOut): string
    {
        $date = date("Y-m-d");          //
        if(($date > $wantedCheckIn)){   // Checking the validity of the date 
            return "Incorrect time";    //  depending on the current
        }                               //

        function compareByCheckIn($a, $b) {
            $dateA = strtotime($a[1]);
            $dateB = strtotime($b[1]);
            return $dateA - $dateB;
        }
        usort($bookingList, 'compareByCheckIn'); // List sorting by CheckIn

        $loop = 0; $bookedRoomType = 0;

        foreach ($bookingList as $selectedBooking) {
            $bookedRoom = $selectedBooking[0];      //
            $bookedCheckIn = $selectedBooking[1];   // Selected information from Booking List
            $bookedCheckOut = $selectedBooking[2];  //

            if($bookedRoom == $wantedRoom){ // Is our Room?
                $bookedRoomType += 1;       
                if(($bookedRoomType == 1) && ($wantedCheckOut < $bookedCheckIn)) return "Your room is booked now"; // Earliest booking
                
                // Finding a time gap where booking is possible
                if($bookedCheckOut < $wantedCheckIn){ 
                    if(($bookingList[$loop+1]) && ($bookingList[$loop+1][0] == $wantedRoom)){   
                        if($bookingList[$loop+1][1] > $wantedCheckOut){                             
                            return "Your room is booked now";
                        }
                    }
                    else return "Your room is booked now";
                }
            }
            $loop = $loop + 1; // Keeps track of list items
        }
        return "Sorry, impossible booking time";
    }

    public function cancelBooking(array $bookingList, array $bookingForCancel){
            foreach ($bookingList as $key => $selectedBooking) {
                if ($selectedBooking[0] === $bookingForCancel[0] && $selectedBooking[1] === $bookingForCancel[1] && $selectedBooking[2] === $bookingForCancel[2]) {
                    unset($bookingList[$key]); // Delete
                    $bookingList = array_values($bookingList); // List update
                    return true; 
                }
            }
            return false; 
    }
}

