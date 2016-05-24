# Brainteaser-API

[![Build Status](https://travis-ci.org/floegel/brainteaser-api.svg?branch=master)](https://travis-ci.org/floegel/brainteaser-api)

Ein erweitertes Code-Sample von <a href="http://jan-floegel.de" target="_blank">Jan Flögel</a>

#### Technologien:
    PHP7, PostgreSQL, nginx, Vagrant, Shell

#### Frameworks/Tools:
    Symfony, Doctrine, Tactician, PHPUnit, Mockery, Behat, Guzzle, Swagger, Make

#### Konzepte:
    DDD, CQRS, CommandBus, DotEnv, Controller as a Service

## Beschreibung
Die Brainteaser-API ist eine REST-Schnittstelle über die ein Gehirntraining durchgeführt werden kann.

Die API umfasst eine Übungsart namens "Bunte Kacheln", die zur Verbesserung der Merkfähigkeit dient.

Die Übung zielt darauf ab, dass dem Benutzer ein Raster aus Kacheln
präsentiert wird, in welchem eine Auswahl an Kacheln für kurze Zeit (farbig) hervorgehoben wird.
Diese muss er sich merken und anschliessend wiedergeben, um die Übung
zu lösen.

Die Übung kann innerhalb eines Trainings 12 Mal durchgeführt werden.
Beginnend bei Schwierigkeitsgrad 1 kann sie dabei schrittweise schwieriger werden:

| Schwierigkeitsgrad | Rastergröße | Markierte Kacheln |
|:------------------:|:-----------:|:-----------------:|
| 1                  | 4x4         | 4                 |
| 2                  | 4x4         | 5                 |
| 3                  | 5x4         | 6                 |
| 4                  | 5x4         | 7                 |
| 5                  | 5x5         | 8                 |
| 6                  | 5x5         | 9                 |
| 7                  | 6x5         | 10                |
| 8                  | 6x5         | 11                |
| 9                  | 6x6         | 12                |
| 10                 | 6x6         | 13                |
| 11                 | 7x6         | 14                |
| 12                 | 7x6         | 15                |

Der Schwierigkeitsgrad wird allerdings nur erhöht, sofern die Übung perfekt gelöst
werden konnte, d.h. alle Kacheln richtig wiedergegeben wurden. Ist dies nicht der Fall,
wird der Schwierigkeitsgrad bei der nächsten Übung beibehalten. Wird eine Übung zwei Mal
in Folge nicht komplett gelöst, wird der Schwierigkeitsgrad für die nächste Übung
verringert.

## API-Fehlercodes
Übung starten:

| API-Fehlercode                      | Beschreibung                                                                                           |
|:-----------------------------------:|:------------------------------------------------------------------------------------------------------:|
| TRAINING-UNSOLVED-EXERCISES         | Wenn eine neue Übung gestartet wird, muss die vorherige Übung (falls vorhanden) gelöst worden sein     |
| TRAINING-AMOUNT-EXERCISES-EXCEEDED  | Ein Training umfasst 12 Übungen. Darüber hinaus können keine neuen Übungen gestartet werden            |
| TRAINING-ALREADY-FINISHED           | Wenn das Training bereits beendet wurde, können keine neuen Übungen gestartet werden                   |

Übung lösen:

| API-Fehlercode                      | Beschreibung                                                                                           |
|:-----------------------------------:|:------------------------------------------------------------------------------------------------------:|
| EXERCISE-ALREADY-SOLVED             | Wenn eine Übung bereits gelöst wurden, kann sie nicht nochmal gelöst werden |
| INPUT-MALFORMED-JSON                | Inputvalidierung: Ungültiges JSON |
| INPUT-MISSING-PARAMETER             | Inputvalidierung: Fehlender Key "tiles" |
| INPUT-INVALID-VALUE                 | Inputvalidierung: Ungültig formatierte Daten für den Key "tiles" |

## Frontend
Ein exemplarisches Frontend, welches diese API verwendet, ist der <a href="http://github.com/floegel/brainteaser-client" target="_blank">brainteaser-client</a>

## Workflow
Das Training wird gestartet, indem eine neue Trainings-Session erstellt wird:

    POST /trainings

Im Location-Header befindet sich der URI der Training-Session.
Die Daten können wiefolgt abgerufen werden:

    GET /trainings/{training_id}

Anschliessend kann eine Übung gestartet werden:

    POST /trainings/{training_id}/exercises

Im Location-Header befindet sich der URI der Übung.
Die Daten können wiefolgt abgerufen werden:

    GET /trainings/{training_id}/exercises/{exercise_id}

Der Lösungsversuch des Benutzers kann daraufhin über folgenden URI mitgeteilt werden:

    POST /trainings/{training_id}/exercises/{exercise_id}/solve

Je nachdem wie akkurat die Lösung des Benutzers war, wird die Punktzahl (score) für
sein Training erhöht.

Die Trainings mit der höchsten Punktzahl lassen sich abrufen über:

    GET /trainings/highscores

## Installation / Setup

Box hochfahren:

    vagrant up

Einwählen in die Box und in das Project-Root-Verzeichnis wechseln:

    vagrant ssh
    cd /vagrant

Das Setup erfolgt über Make. Eine Liste aller verfügbaren Kommandos kann wiefolgt erhalten werden:

    make help

#### Setup des Projekts
    make setup

#### Setup der Datenbank
    make setup-db

#### Datenbank mit Testdaten füllen
    make reseed-db

Verfügbare Testdaten:

Trainings

| ID                                   | Kommentar                                                     | Zum Testen von API-Fehlercode         |
|:------------------------------------:|:-------------------------------------------------------------:|:-------------------------------------:|
| 83157cf2-d628-4a60-bf77-84fd2b759155 | Hat noch keine Übung                                          | -                                     |
| b2d16e8b-f334-4e37-b660-204485e7f7ef | Hat bereits 12 Übungen (letzte Übung noch nicht gelöst)       | -                                     |
| c334443e-bcad-4b44-b704-f5773ac16e17 | Hat eine ungelöste Übung                                      | TRAINING-UNSOLVED-EXERCISES           |
| ba806c8c-f567-48fa-9e8c-f1dbdbd9ae5e | Training bereits beendet - taucht in Highscores auf (Platz 1) | TRAINING-ALREADY-FINISHED             |
| de33b842-5281-4b0b-b584-2cbb1d7b4e21 | Training bereits beendet - taucht in Highscores auf (Platz 2) | TRAINING-ALREADY-FINISHED             |

Übungen

| ID                                   | Training-ID                          | Kommentar                   | Zum Testen von API-Fehlercode         |
|:------------------------------------:|:------------------------------------:|:---------------------------:|:-------------------------------------:|
| 80d7c3a5-eee5-4e3a-aa08-872cfa970380 | c334443e-bcad-4b44-b704-f5773ac16e17 | Noch nicht gelöst           | -                                     |
| c8668927-ea80-439f-b30d-a2271e079158 | ba806c8c-f567-48fa-9e8c-f1dbdbd9ae5e | Bereits gelöst              | EXERCISE-ALREADY-SOLVED               |


#### Integrationstests ausführen
    make test

#### HTML-Coverage-Report zu den Integrationstests erzeugen
    make test-report

#### Unit-Tests ausführen
    make unit-test

#### HTML-Coverage-Report zu den Unit-Tests erzeugen
    make unit-test-report

#### API-Doc publishen
    make api-doc
Danach ist die API-Dokumentation verfügbar unter http://192.168.50.7/api-doc/#/default




