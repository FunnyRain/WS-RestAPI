SQLite format 3   @     C                                                               C .?�� � ��                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              �2�CtableusersusersCREATE TABLE users (
            owner_id INTEGER PRIMARY KEY, 
            firstname VARCHAR (50) NOT NULL, 
            lastname VARCHAR (50) NOT NULL, 
            phone CHAR(11) NOT NULL CHECK (length(phone) < 12),
            password VARCHAR (50) NOT NULL
        , token TEXT)�a�tablephotosphotosCREATE TABLE photos (
            owner_id INTEGER, 
            photo VARCHAR (50) NOT NULL, 
            photo_id INTEGER PRIMARY KEY, 
            url VARCHAR(250),
            users TEXT
        )  )                                                                                                                                                                                                                                                                                                        � ��                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        �                                                                                                                                                                                                                                                                                     d                                                                                                ] �	DanilaMash102030test123OwpEozLiklZbDfa7n1RKHxM5SgGu0Vt2hQFJT6cyqBeWCY4Nd3rIPjAvs9UX8m 123421412313214password   0 ��0�mmmm                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     �                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             D                                                                                                                rU �JkQrLDW7go3Ozv0FGpePS896s2cKAN4x.pnghttp://localhost:8080/photos/temp/JkQrLDW7go3Ozv0FGpePS896s2cKAN4x.pngrU �ikQDYa8NLsJGBupMlmK9VShOPxZegWUA.pnghttp://localhost:8080/photos/temp/ikQDYa8NLsJGBupMlmK9VShOPxZegWUA.pngrU �d7cyYp3XCSJ1ONDU0wTGMR69toAeqIjH.pnghttp://localhost:8080/photos/temp/d7cyYp3XCSJ1ONDU0wTGMR69toAeqIjH.pngrU �41EmKQ8SutJZ3hLDab0HsxeliXGBfpFA.pnghttp://localhost:8080/photos/temp/41EmKQ8SutJZ3hLDab0HsxeliXGBfpFA.png