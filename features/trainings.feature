Feature: API Resource: Training
  In order to manage a training (session) for an user
  As an API-consumer
  I need to be able to create a training, get the data of a training and get the highscores

  Scenario: Create training
    Given I send a POST request to "/trainings"
    Then the response should be json
      And the response status code should be 201
      And the response has a "Location" header which looks like "/^\/trainings\/([a-z0-9-]){36}$/"
      And the response should contain json:
      """
      {}
      """

  Scenario: Get training
    Given I send a GET request to "/trainings/83157cf2-d628-4a60-bf77-84fd2b759155"
    Then the response status code should be 200
      And the response should contain json:
      """
      {
        "data": {
          "id": "83157cf2-d628-4a60-bf77-84fd2b759155",
          "score": 0,
          "num_exercises": 12
        }
      }
      """

  Scenario: Get non-existant training
    Given I send a GET request to "/trainings/42"
    Then the response should be json
      And the response status code should be 404
      And the response should contain json:
      """
      {}
      """

  Scenario: Get highscores
    Given I send a GET request to "/trainings/highscores"
    Then the response should be json
      And the response status code should be 200
      And the response should contain json:
      """
      {
        "data": [
          {
            "id": "ba806c8c-f567-48fa-9e8c-f1dbdbd9ae5e",
            "score": 9600,
            "num_exercises": 12
          },
          {
            "id": "de33b842-5281-4b0b-b584-2cbb1d7b4e21",
            "score": 8700,
            "num_exercises": 12
          }
        ]
      }
      """