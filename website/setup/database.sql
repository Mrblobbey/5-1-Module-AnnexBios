-- dit is om je tickets met seat_id te bewaren
ALTER TABLE tickets
  ADD COLUMN movie_screening_id INT NOT NULL,
  ADD UNIQUE KEY uniq_ticket (movie_screening_id, seat_id);