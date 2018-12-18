<?php
class RoughIn
{
  public static function updateDatabase($events)
  {
    // Convert data to table format (SQL-like)
    $dbItemList = self::dbItemListFromEventData($events);
    
    // Sort data by EventID, Room, Category, and Name
    // alphabetically ascending like SQL "ASC"
    $sortedDbItemList = self::sortedDbItemList($dbItemList);
    self::putDataInJsonFile($sortedDbItemList, "dbList-sorted");

    $updateList = [];
    $addList = [];
    $deleteList = [];

    $dbItems = []; // insert a SQL query to get items currently in db for event
    $items = $sortedDbItemList;
    $dbIndex = 0;
    $itemIndex = 0;
    $lengthOfLongerList = 0; // change to choose length of longer list
    // Loop through $event and $dbItemList by looping by number
    // using a number equal to the length of the longer of the 
    // two lists
    for ($i = 0; $i < $lengthOfLongerList; $i++) {
      // In each iteration of the loop:
      $dbItem = $dbItems[$dbIndex];
      $newItem = $items[$itemIndex];

      // check if the item in each list is the same item
      $situation = self::compareItems($dbItem, $newItem);
      // should retun "same", "update", or "different"

      if ($situation === "update") {
        // if "update" run update function to add updates to list 
        // and update indexes
        $updateList = self::addToUpdateList($updateList, $dbItem, $newItem);

        $dbIndex++;
        $itemIndex++;
      } elseif ($situation = "different") {
        // if different, decide whether it's an add or delete
        $addOrDelete = self::addOrDelete($dbItem, $newItem);

        // and run the respective function to add to the one list or the other
        // also only increase the correct index (the one that has the extra item)
        if ($addOrDelete === "add") {
          $addList = self::addToAddList($addList, $newItem);
          $itemIndex++;
        } elseif ($addOrDelete === "delete") {
          $deleteList = self::addToDeleteList($deleteList, $dbItem);
          $dbIndex++;
        }
      }

        // if "same", don't to anything
    }

    // then run the sql commands on each item in the three lists:
    // updates, deletions, and additions - using transactions for
    // fewer database calls
  }

  public static function dbItemListFromEventData($events)
  {
    if (sizeof($events) > 1) {
      self::logErr("more than one event in data", "converting event data");
    }

    $event = $events[0];
    $dbItemList = [];
    foreach ($event["rooms"] as $room) {
      foreach ($room["categories"] as $category) {
        foreach ($category["items"] as $item) {
          $dbItem = [];
          $dbItem["eventId"] = $event["id"];
          $dbItem["room"] = $room["name"];
          $dbItem["category"] = $category["name"];
          $dbItem["name"] = $item["name"];
          $dbItem["qty"] = $item["qty"] ?? 1;
          $dbItem["startDate"] = $item["startDate"] ?? null;
          $dbItem["startTime"] = $item["startTime"] ?? null;
          $dbItem["endDate"] = $item["endDate"] ?? null;
          $dbItem["endTime"] = $item["endTime"] ?? null;
          if ($item["note"] <> "NA") {
            $dbItem["note"] = $item["note"] ?? "";
          } else {
            $dbItem["note"] = "";
          }

          array_push($dbItemList, $dbItem);
        }
      }
      foreach ($room["combine"] as $combine) {
        $dbItem = [];
        $dbItem["eventId"] = $event["id"];
        $dbItem["room"] = $room["name"];
        $dbItem["category"] = $combine["category"];
        $dbItem["name"] = $combine["name"];
        $dbItem["qty"] = 1;

        //TODO: Figure these dates out and add them
        $dbItem["startDate"] = null;
        $dbItem["startTime"] = null;
        $dbItem["endDate"] = null;
        $dbItem["endTime"] = null;

        array_push($dbItemList, $dbItem);
      }
    }

    return $dbItemList;
  }

  public static function sortedDbItemList($dbItemList)
  {
    usort($dbItemList, function ($item1, $item2) {
      if ($item1['eventId'] != $item2['eventId']) {
        return $item1['eventId'] <=> $item2['eventId'];
      }
      if ($item1['room'] != $item2['room']) {
        return $item1['room'] <=> $item2['room'];
      }
      if ($item1['category'] != $item2['category']) {
        return $item1['category'] <=> $item2['category'];
      }
      return $item1["name"] <=> $item2["name"];
    });

    return $dbItemList;
  }

  public static function compareItems($dbItem, $newItem)
  {
    return "same"; // for exact same item with no changes
    //  or "update" for same item with differences
    //  or "different" for different items
  }

  public static function addOrDelete($dbItem, $newItem)
  {
    return "add"; // if $newItem should be next alphabetically
    //  or "delete" if $dbItem should be next alphabetically
  }

  public static function addToUpdateList($updateList, $dbItem, $newItem)
  {
    return $updateList; // with items properly merged together using new info
                        // and then added to the given list
  }

  public static function addToAddList($addList, $newItem) {
    return $addList; // with new item added
  }

  public static function addToDeleteList($deleteList, $dbItem) {
    return $deleteList; // with item to delete added to list
  }
  
