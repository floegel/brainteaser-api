Feature: API Resource: Exercise
  In order to let an user perform exercises
  As an API-consumer
  I need to be able to create an exercise, get the data of an exercise and solve an exercise

  Scenario: Create exercise
    Given I send a POST request to "/trainings/83157cf2-d628-4a60-bf77-84fd2b759155/exercises"
    Then the response status code should be 201
      And the response has a "Location" header which looks like "/^\/trainings\/83157cf2-d628-4a60-bf77-84fd2b759155\/exercises\/([a-z0-9-]){36}$/"
      And the response should contain json:
        """
        {}
        """

  Scenario: Create exercise for non-existant training
    Given I send a POST request to "/trainings/42/exercises"
    Then the response should be json
      And the response status code should be 404
      And the response should contain json:
        """
        {}
        """

  Scenario: Create exercise for training with unsolved exercises
    Given I send a POST request to "/trainings/c334443e-bcad-4b44-b704-f5773ac16e17/exercises"
    Then the response should be json
      And the response status code should be 400
      And the response should contain json with error-code "TRAINING-UNSOLVED-EXERCISES"

  Scenario: Create exercise for training that has already been finished
    Given I send a POST request to "/trainings/ba806c8c-f567-48fa-9e8c-f1dbdbd9ae5e/exercises"
    Then the response should be json
      And the response status code should be 400
      And the response should contain json with error-code "TRAINING-ALREADY-FINISHED"

  Scenario: Get exercise
    Given I send a GET request to "/trainings/c334443e-bcad-4b44-b704-f5773ac16e17/exercises/80d7c3a5-eee5-4e3a-aa08-872cfa970380"
    Then the response status code should be 200
      And the response should contain json:
        """
        {
          "data": {
            "id": "80d7c3a5-eee5-4e3a-aa08-872cfa970380",
            "num": 1,
            "grid_size": {
              "rows": 4,
              "cols": 4
            },
            "colored_tiles": [
              {
                "x": 1,
                "y": 1
              },
              {
                "x": 3,
                "y": 0
              },
              {
                "x": 3,
                "y": 3
              },
              {
                "x": 3,
                "y": 2
              }
            ],
            "solved": false
          }
        }
        """

  Scenario: Get non-existant exercise
    Given I send a GET request to "/trainings/c334443e-bcad-4b44-b704-f5773ac16e17/exercises/42"
    Then the response should be json
      And the response status code should be 404
      And the response should contain json:
          """
          {}
          """

  Scenario: Get existing exercise for invalid training
    Given I send a GET request to "/trainings/42/exercises/80d7c3a5-eee5-4e3a-aa08-872cfa970380"
    Then the response should be json
      And the response status code should be 404
      And the response should contain json:
        """
        {}
        """

  Scenario: Solve exercise
    Given I send a POST request to "/trainings/c334443e-bcad-4b44-b704-f5773ac16e17/exercises/80d7c3a5-eee5-4e3a-aa08-872cfa970380/solve" with body:
    """
    {
      "tiles": [
        { "x": 1, "y": 1 },
        { "x": 3, "y": 0 },
        { "x": 3, "y": 3 },
        { "x": 3, "y": 2 }
      ]
    }
    """
    Then the response should be json
      And the response status code should be 200
      And the response should contain json:
      """
      {
        "data": {
          "correct": [
            {
              "x": 1,
              "y": 1
            },
            {
              "x": 3,
              "y": 0
            },
            {
              "x": 3,
              "y": 3
            },
            {
              "x": 3,
              "y": 2
            }
          ],
          "wrong": [],
          "missing": [],
          "score": 400
        }
      }
       """

  Scenario: Solve non-existant exercise
    Given I send a POST request to "/trainings/c334443e-bcad-4b44-b704-f5773ac16e17/exercises/42/solve" with body:
    """
    {
      "tiles": [
        { "x": 1, "y": 1 },
        { "x": 3, "y": 0 },
        { "x": 3, "y": 3 },
        { "x": 3, "y": 2 }
      ]
    }
    """
    Then the response should be json
      And the response status code should be 404
      And the response should contain json:
      """
      {}
      """

  Scenario: Solve existing exercise for invalid training
    Given I send a POST request to "/trainings/42/exercises/80d7c3a5-eee5-4e3a-aa08-872cfa970380/solve" with body:
    """
    {
      "tiles": [
        { "x": 1, "y": 1 },
        { "x": 3, "y": 0 },
        { "x": 3, "y": 3 },
        { "x": 3, "y": 2 }
      ]
    }
    """
    Then the response should be json
      And the response status code should be 404
      And the response should contain json:
      """
      {}
      """

  Scenario: Solve exercise with malformed json as input
    Given I send a POST request to "/trainings/c334443e-bcad-4b44-b704-f5773ac16e17/exercises/80d7c3a5-eee5-4e3a-aa08-872cfa970380/solve" with body:
    """
    this is just a string
    """
    Then the response should be json
      And the response status code should be 400
      And the response should contain json with error-code "INPUT-MALFORMED-JSON"

  Scenario: Solve exercise with missing fields in input
    Given I send a POST request to "/trainings/c334443e-bcad-4b44-b704-f5773ac16e17/exercises/80d7c3a5-eee5-4e3a-aa08-872cfa970380/solve" with body:
    """
    {}
    """
    Then the response should be json
      And the response status code should be 400
      And the response should contain json with error-code "INPUT-MISSING-PARAMETER"

  Scenario: Solve exercise with invalid value in input
    Given I send a POST request to "/trainings/c334443e-bcad-4b44-b704-f5773ac16e17/exercises/80d7c3a5-eee5-4e3a-aa08-872cfa970380/solve" with body:
    """
    {
      "tiles": [
        { "coord": "1-1" }
      ]
    }
    """
    Then the response should be json
      And the response status code should be 400
      And the response should contain json with error-code "INPUT-INVALID-VALUE"

  Scenario: Solve exercise that has already been solved
    Given I send a POST request to "/trainings/ba806c8c-f567-48fa-9e8c-f1dbdbd9ae5e/exercises/c8668927-ea80-439f-b30d-a2271e079158/solve" with body:
    """
    {
      "tiles": [
        { "x": 1, "y": 1 },
        { "x": 3, "y": 0 },
        { "x": 3, "y": 3 },
        { "x": 3, "y": 2 }
      ]
    }
    """
    Then the response should be json
      And the response status code should be 400
      And the response should contain json with error-code "EXERCISE-ALREADY-SOLVED"