<?php
function uiIdToSeatParts(string $ui): array {
  // "stoel_R_12" of "stoel_8_2" -> ['row' => '8', 'num' => 2]
  // Jij gebruikt cijfers als rijen; als je letters wilt, pas dit aan.
  [$prefix, $row, $num] = explode('_', $ui);
  return ['row' => $row, 'num' => (int)$num];
}

function findSeatId(PDO $pdo, int $screenId, string $rowLabel, int $seatNum): ?int {
  $q = $pdo->prepare("SELECT seat_id FROM seats 
                      WHERE screen_id = :sid AND row_label = :r AND seat_number = :n LIMIT 1");
  $q->execute([':sid'=>$screenId, ':r'=>$rowLabel, ':n'=>$seatNum]);
  $row = $q->fetch();
  return $row ? (int)$row['seat_id'] : null;
}
?>