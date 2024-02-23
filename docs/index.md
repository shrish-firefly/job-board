
---

## Job Board API Documentation

### Base URL

The base URL for all API endpoints is `http://localhost:8000/api/v1` and Accept header should be `application/json` for all routes.

### Authentication Endpoints

#### Register a New User

- **URL:** `POST /auth/register`
- **Description:** Register a new user with the provided details.
- **Request Body:**
  ```json
  {
      "name": "string",
      "email": "string",
      "password": "string",
      "password_confirmation": "string"
  }
  ```
- **Response:**
  - Status Code: `201 Created`
  - Body:
    ```json
    {
        "message": "User created successfully",
        "user": {
            "id": 1,
            "name": "string",
            "email": "string",
            "created_at": "timestamp",
            "updated_at": "timestamp"
        }
    }
    ```

#### Login

- **URL:** `POST /auth/login`
- **Description:** Login with existing user credentials.
- **Request Body:**
  ```json
  {
      "email": "string",
      "password": "string"
  }
  ```
- **Response:**
  - Status Code: `200 OK`
  - Body:
    ```json
    {
        "user": {
            "id": 1,
            "name": "string",
            "email": "string",
            "created_at": "timestamp",
            "updated_at": "timestamp"
        },
        "authorization": {
            "token": "string",
            "type": "bearer"
        }
    }
    ```

#### Logout

- **URL:** `POST /auth/logout`
- **Description:** Logout the current user.
- **Authorization Header:** `Bearer {token}`
- **Response:**
  - Status Code: `200 OK`
  - Body:
    ```json
    {
        "message": "Logged out successfully"
    }
    ```

#### Get User Details

- **URL:** `GET /auth/user`
- **Description:** Get details of the authenticated user.
- **Authorization Header:** `Bearer {token}`
- **Response:**
  - Status Code: `200 OK`
  - Body:
    ```json
    {
        "message": "",
        "user": {
            "id": 1,
            "name": "string",
            "email": "string",
            "created_at": "timestamp",
            "updated_at": "timestamp"
        }
    }
    ```

### Job Listing Endpoints

#### Create a Job Listing

- **URL:** `POST /listings`
- **Description:** Create a new job listing.
- **Authorization Header:** `Bearer {token}`
- **Request Body:**
  ```json
  {
      "job_title": "string",
      "description": "string",
      "instructions": "string",
      "location": "string",
      "company_name": "string"
  }
  ```
- **Response:**
  - Status Code: `200 OK`
  - Body:
    ```json
    {
        "message": "Listing created successfully!",
        "listing": {
            "id": 1,
            "job_title": "string",
            "description": "string",
            "instructions": "string",
            "location": "string",
            "company_name": "string",
            "created_at": "timestamp",
            "updated_at": "timestamp",
            "at_url": "http://127.0.0.1:8000/api/v1/listing/1/applications"
        }
    }
    ```

#### Get All Job Listings

- **URL:** `GET /listings`
- **Description:** Get all job listings created by the authenticated user.
- **Authorization Header:** `Bearer {token}`
- **Response:**
  - Status Code: `200 OK`
  - Body:
    ```json
    {
        "message": "",
        "listings": [
            {
                "id": 1,
                "job_title": "string",
                "description": "string",
                "instructions": "string",
                "location": "string",
                "company_name": "string",
                "created_at": "timestamp",
                "updated_at": "timestamp",
                "at_url": "http://127.0.0.1:8000/api/v1/listing/1/applications"
            }
        ]
    }
    ```

#### Get Job Listing Details

- **URL:** `GET /listings/{id}`
- **Description:** Get details of a specific job listing.
- **Authorization Header:** `Bearer {token}`
- **Response:**
  - Status Code: `200 OK`
  - Body:
    ```json
    {
        "message": "",
        "listing": {
            "id": 1,
            "job_title": "string",
            "description": "string",
            "instructions": "string",
            "location": "string",
            "company_name": "string",
            "created_at": "timestamp",
            "updated_at": "timestamp",
            "at_url": "http://127.0.0.1:8000/api/v1/listing/1/applications"
        }
    }
    ```

#### Update Job Listing

- **URL:** `POST /listings/{id}`
- **Description:** Update details of a specific job listing.
- **Authorization Header:** `Bearer {token}`
- **Request Body:**
  ```json
  {
      "_method": "PUT",
      "job_title": "string",
      "description": "string",
      "instructions": "string",
      "location": "string",
      "company_name": "string"
  }
  ```
- **Response:**
  - Status Code: `200 OK`
  - Body:
    ```json
    {
        "message": "Listing updated successfully!",
        "listing": {
            "id": 1,
            "job_title": "string",
            "description": "string",
            "instructions": "string",
            "location": "string",
            "company_name": "string",
            "created_at": "timestamp",
            "updated_at": "timestamp",
            "at_url": "http://127.0.0.1:8000/api/v1/listing/1/applications"
        }
    }
    ```

#### Delete Job Listing

- **URL:** `POST /listings/{id}`
- **Description:** Delete a specific job listing.
- **Authorization Header:** `Bearer {token}`
- **Request Body:**
  ```json
  {
      "_method": "DELETE",
  }
  ```
- **Response:**
  - Status Code: `200 OK`
  - Body:
    ```json
    {
        "message": "Listing deleted successfully!",
        "listing": {
            "id": 1,
            "job_title": "string",
            "description": "string",
            "instructions": "string",
            "location": "string",
            "company_name": "string",
            "created_at": "timestamp",
            "updated_at": "timestamp",
            "at_url": "http://127.0.0.1:8000/api/v1/listing/1/applications"
        }
    }
    ```

#### Get Applications for a Job Listing

- **URL:** `GET /listings/{id}/applications`
- **Description:** Get all applications for a specific job listing.
- **Authorization Header:** `Bearer {token}`
- **Response:**
  - Status Code: `200 OK`
  - Body:
    ```json
    {
        "message": "",
        "applications": [
            {
                "id": 1,
                "resume": "string",
                "cover_letter": "string",
                "submitted_at": "timestamp",
            }
        ]
    }
    ```

#### Search Job Listings

- **URL:** `GET /listing`
- **Description:** Search for job listings based on title, location, or company name.
- **Query Parameters:**
  - `title`: Title of the job listing (optional)
  - `location`: Location of the job (optional)
  - `company_name`: Name of the company (optional)
- **Response:**
  - Status Code: `200 OK`
  - Body:
    ```json
    {
        "message": "",
        "listings": [
            {
                "id": 1,
                "job_title": "string",
                "description": "string",
                "instructions": "string",
                "location": "string",
                "company_name": "string",
                "user_id": 1,
                "created_at": "timestamp",
                "updated_at": "timestamp",
                "apply_url": "http://127.0.0.1:8000/api/v1/listing/1/apply"
            }
        ]
    }
    ```

#### Apply for a Job Listing

- **URL:** `POST /listing/{id}/apply`
- **Description:** Apply for a specific job listing by uploading a resume and cover letter.
- **Request Body:**
  - `resume`: Resume file (multipart/form-data)
  - `cover_letter`: Cover letter text
- **Response:**
  - Status Code: `201 OK`
  - Body:
    ```json
    {
        "message": "Applied successfully"
    }
    ```

---
