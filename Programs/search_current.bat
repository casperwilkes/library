@ECHO OFF
REM SET TITLE
TITLE Search Current Directory and Sub Directory

REM Output Directions
ECHO ==========================
ECHO This is a simple search program. Be exact when searching. 
ECHO This will serach the current directory and all subdirectories. 
ECHO The nature of the search will be case insensitive.
ECHO The name of the file where the search term appears will be listed below.
ECHO The window will notify you when the search is complete and allow you a chance to capture the results. 
ECHO ==========================

:SEARCH

ECHO:
REM Set search
SET /p find=What would you like to find? 
ECHO:
ECHO Searching For: "%find%"
ECHO:

REM Search:
REM -s :: Search current directory and subdirectories
REM -i :: Search is case insensitive
REM -m :: Prints file name
FINDSTR -s -i -m %find%  *.*

REM Evaluate find
if errorlevel 1 (
	ECHO Nothing found for: "%find%"
)

REM Let user know search complete
ECHO:
ECHO Search For "%find%" Complete.
ECHO:

REM Ask if program should search again
SET /p exit=Would you like to search again[y/n]? 

REM Either search again or exit program
IF "%exit%" == "y" (
	GOTO SEARCH
) ELSE (
	EXIT
)