use mit57;

SELECT ratings.ratingsID, ratings.rating, beers.beerName, beers.beerABV, beers.beerStyle, finalUsers.userName
FROM beers
INNER JOIN ratings ON ratings.beerID_fk= beers.beerID
INNER JOIN finalUsers ON finalUsers.finalUserID=ratings.finalUsersID_fk
WHERE finalUsers.userName = 'test';

