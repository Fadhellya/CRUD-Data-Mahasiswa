pipeline {
    agent any
    environment {
        DOCKER_USERNAME = credentials('usernamedocker')
        DOCKER_PASSWORD = credentials('passworddocker')
        KUBE_CONFIG = credentials('KUBE_KONFIG')  // Add Kubernetes kubeconfig file to Jenkins credentials
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

        stage('Generate Date-Based Tag') {
            steps {
                script {
                    // Get the current date in the format YYYYMMDD
                    def currentDate = new Date().format('yyyyMMdd')
                    // Get the current time in hours and minutes
                    def currentTime = new Date().format('HHmm')
                    // Combine date and time to create a unique tag
                    env.NEW_VERSION = "${currentDate}-${currentTime}"
                }
            }
        }

        stage('Build Docker Image') {
            steps {
                script {
                    // Generate the image name using the new date-based version
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
