<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
include 'BookingManager_file.php';

final class BookingTest extends TestCase
{
    // Room Adding Test
    public function test_addRoom(): void
    {
        $x = new BookingManagerClass();
        
        $roomNumber = 4;                    //
        $roomType = "Standard";             // Room that we want to add
        $room = [$roomNumber, $roomType];   //

        $roomsList = [
            [1, "Standard"],
            [2, "VIP"],
            [3, "Standard"]
        ];

        $result = $x->addRoom($roomsList, $room);
        

        $this->assertTrue($result, "Add Room Test"); // Will be OK
    }

    // Room Booking Test
    public function test_bookRoom(): void
    {
        $x = new BookingManagerClass();
        
        // Existing rooms
        $roomsList = [
            [1, "Standard"],
            [2, "VIP"],
            [3, "Standard"] // Room number that we want to book
        ];

        // Booking List
        $bookingList = [    // room , checkIn, checkOut 
            [$roomsList[0], date('2024-06-01'), date('2024-07-01')], 
            [$roomsList[0], date('2025-01-01'), date('2025-03-01')], 
            [$roomsList[2], date('2025-03-01'), date('2025-04-01')], 
            [$roomsList[2], date('2025-07-01'), date('2025-08-01')] 
        ];

        $wantedRoom = $roomsList[2];        //
        $checkIn = date('2025-02-01');      // Room that we want to book
        $checkOut = date('2025-04-01');     //

        $result = $x->bookRoom($bookingList, $roomsList, $wantedRoom, $checkIn, $checkOut);
        

        $this->assertSame("Your room is booked now", $result, "Room Booking"); // Will be FAILURE
    }

    // Booking Canceling Test
    public function test_cancelBooking(): void
    {
        $x = new BookingManagerClass();
        
        // Existing rooms
        $roomsList = [
            [1, "Standard"],
            [2, "VIP"],
            [3, "Standard"] // Room number that we want to book
        ];

        // Booking List
        $bookingList = [    // room , checkIn, checkOut 
            [$roomsList[0], date('2024-06-01'), date('2024-07-01')], 
            [$roomsList[0], date('2025-01-01'), date('2025-03-01')], 
            [$roomsList[2], date('2025-03-01'), date('2025-04-01')], 
            [$roomsList[2], date('2025-07-01'), date('2025-08-01')] 
        ];

        $result = $x->cancelBooking($bookingList, $bookingList[0]); //
        

        $this->assertTrue($result, "Booking Canceling"); // Will be OK
    }

}

