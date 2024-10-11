pipeline {
    agent any
    environment {
        DOCKER_USERNAME = credentials('usernamedocker')
        DOCKER_PASSWORD = credentials('passworddocker')
        KUBE_CONFIG = credentials('KUBE_KONFIG')  // Add Kubernetes kubeconfig file to Jenkins credentials
        VERSION_FILE = '/home/master/ImageVersion/version.txt' // File to store the current version
    }

    options {
        timeout(time: 30, unit: 'MINUTES')
    }

    stages {
        stage('Checkout') {
            steps {
                checkout scm
            }
        }

        stage('Read Current Version') {
            steps {
                script {
                    // Check if version.txt exists
                    if (fileExists(VERSION_FILE)) {
                        // Read the current version
                        env.CURRENT_VERSION = readFile(VERSION_FILE).trim()
                    } else {
                        // If it doesn't exist, start with version 0.01
                        env.CURRENT_VERSION = '0.01'
                    }
                    
                    // Increment the version
                    def versionParts = env.CURRENT_VERSION.split('\\.')
                    def major = versionParts[0].toInteger()
                    def minor = versionParts[1].toInteger() + 1 // Increment minor version
                    env.NEW_VERSION = "${major}.${minor.toString().padLeft(2, '0')}" // Format with leading zero
                }
            }
        }

        stage('Save New Version') {
            steps {
                script {
                    // Save the new version to the version file
                    writeFile(file: VERSION_FILE, text: env.NEW_VERSION)
                }
            }
        }

        stage('Build Docker Image') {
            steps {
                script {
                    // Generate the image name using the new version
                    env.IMAGE_NAME = "fadhellya/sample:${env.NEW_VERSION}"

                    // Build the Docker image
                    sh '''
                    docker build -t ${IMAGE_NAME} .
                    '''
                }
            }
        }

        stage('Push Docker Image') {
            steps {
                script {
                    sh '''
                    echo "${DOCKER_PASSWORD}" | docker login -u ${DOCKER_USERNAME} --password-stdin
                    docker push ${IMAGE_NAME}
                    '''
                }
            }
        }

        stage('Deploy to Kubernetes') {
            steps {
                script {
                    echo "Deploying to Kubernetes Cluster"
                    
                    // Use kubectl to apply Kubernetes deployment manifests
                    sh '''
                    export KUBECONFIG=$KUBE_CONFIG
                    kubectl set image deployment/sample-web sample-web=${IMAGE_NAME} --record
                    '''
                }
            }
        }
    }

    post {
        always {
            cleanWs()
        }
        success {
            echo 'Deployment to Kubernetes succeeded!'
        }
        failure {
            echo 'Deployment to Kubernetes failed!'
        }
    }
}
