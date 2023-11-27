CREATE TABLE IF NOT EXISTS UserAllowedVotes(
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    allowed_votes INT NOT NULL DEFAULT 2,
    user_id INT NOT NULL,

    FOREIGN KEY (user_id) REFERENCES Users(id AS user_id)
)

DROP TABLE userallowedvotes;