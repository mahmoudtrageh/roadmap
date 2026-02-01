<?php

namespace Database\Seeders;

use App\Models\Roadmap;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class SystemDesignRoadmapSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@roadmap.camp')->first();

        $roadmap = Roadmap::create([
            'creator_id' => $admin->id ?? 1,
            'title' => 'System Design Fundamentals',
            'description' => 'Learn how to design scalable, reliable, and maintainable systems. Master system design concepts, architectural patterns, and best practices for building production-ready applications.',
            'slug' => 'system-design-fundamentals',
            'duration_days' => 20,
            'difficulty_level' => 'advanced',
            'is_published' => true,
            'is_featured' => false,
            'order' => 11,
            'prerequisite_roadmap_id' => null,
        ]);

        $this->createTasks($roadmap);
    }

    protected function createTasks(Roadmap $roadmap): void
    {
        $tasks = [
            // Day 1: System Design Basics
            [
                'title' => 'Introduction to System Design',
                'description' => 'Understand what system design is, why it matters, and the key principles of scalable systems.',
                'estimated_time_minutes' => 90,
                'task_type' => 'reading',
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=UzLMhqg3_Wc', 'title' => 'System Design Introduction - Gaurav Sen', 'type' => 'video'],
                    ['url' => 'https://www.youtube.com/watch?v=m8Icp_Cid5o', 'title' => 'System Design Course - freeCodeCamp', 'type' => 'video'],
                    ['url' => 'https://github.com/donnemartin/system-design-primer', 'title' => 'System Design Primer - GitHub', 'type' => 'article'],
                ],
            ],

            // Day 2: Scalability Fundamentals
            [
                'title' => 'Horizontal vs Vertical Scaling',
                'description' => 'Learn the difference between horizontal and vertical scaling, when to use each, and their trade-offs.',
                'estimated_time_minutes' => 90,
                'task_type' => 'reading',
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=xpDnVSmNFX0', 'title' => 'Horizontal vs Vertical Scaling - IBM', 'type' => 'video'],
                    ['url' => 'https://www.youtube.com/watch?v=asonXg-usB8', 'title' => 'Scaling Databases - Hussein Nasser', 'type' => 'video'],
                    ['url' => 'https://aws.amazon.com/compare/the-difference-between-horizontal-and-vertical-scaling/', 'title' => 'AWS: Horizontal vs Vertical Scaling', 'type' => 'article'],
                ],
            ],

            // Day 3: Load Balancing
            [
                'title' => 'Load Balancing Concepts',
                'description' => 'Understand load balancing, different algorithms (Round Robin, Least Connection, IP Hash), and their use cases.',
                'estimated_time_minutes' => 90,
                'task_type' => 'reading',
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=K0Ta65OqQkY', 'title' => 'What is Load Balancing? - ByteByteGo', 'type' => 'video'],
                    ['url' => 'https://www.youtube.com/watch?v=7LMaAVwZE2c', 'title' => 'Load Balancing Deep Dive - Hussein Nasser', 'type' => 'video'],
                    ['url' => 'https://aws.amazon.com/what-is/load-balancing/', 'title' => 'AWS: Load Balancing Explained', 'type' => 'article'],
                ],
            ],

            // Day 4: Caching Strategies
            [
                'title' => 'Caching and Cache Strategies',
                'description' => 'Learn about caching, cache-aside, write-through, write-back patterns, and cache invalidation strategies.',
                'estimated_time_minutes' => 100,
                'task_type' => 'reading',
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=U3RkDLtS7uY', 'title' => 'Caching Strategies - Web Dev Simplified', 'type' => 'video'],
                    ['url' => 'https://www.youtube.com/watch?v=dGAgxozNWFE', 'title' => 'Caching Explained - ByteByteGo', 'type' => 'video'],
                    ['url' => 'https://redis.io/docs/latest/develop/use/patterns/caching/', 'title' => 'Redis Caching Patterns', 'type' => 'article'],
                ],
            ],

            // Day 5: Database Fundamentals
            [
                'title' => 'Database Design & Indexing',
                'description' => 'Understand database normalization, denormalization, indexing strategies, and when to use each approach.',
                'estimated_time_minutes' => 100,
                'task_type' => 'reading',
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=HubezKbFL7E', 'title' => 'Database Indexing - Hussein Nasser', 'type' => 'video'],
                    ['url' => 'https://www.youtube.com/watch?v=-qNSXK7s7_w', 'title' => 'Database Design Tips - Fireship', 'type' => 'video'],
                    ['url' => 'https://use-the-index-luke.com/', 'title' => 'Use The Index, Luke! - SQL Performance Guide', 'type' => 'article'],
                ],
            ],

            // Day 6: SQL vs NoSQL
            [
                'title' => 'SQL vs NoSQL Databases',
                'description' => 'Compare SQL and NoSQL databases, understand CAP theorem, and learn when to use each type.',
                'estimated_time_minutes' => 90,
                'task_type' => 'reading',
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=ruz-vK8IesE', 'title' => 'SQL vs NoSQL Explained - Academind', 'type' => 'video'],
                    ['url' => 'https://www.youtube.com/watch?v=QwevGzVu_zk', 'title' => 'SQL vs NoSQL - Fireship', 'type' => 'video'],
                    ['url' => 'https://www.mongodb.com/resources/compare/nosql-vs-sql', 'title' => 'MongoDB: NoSQL vs SQL', 'type' => 'article'],
                ],
            ],

            // Day 7: Database Replication
            [
                'title' => 'Database Replication & Sharding',
                'description' => 'Learn about master-slave replication, multi-master replication, and database sharding strategies.',
                'estimated_time_minutes' => 100,
                'task_type' => 'reading',
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=XP98YCr-iXQ', 'title' => 'Database Sharding Explained', 'type' => 'video'],
                    ['url' => 'https://www.youtube.com/watch?v=5faMjKuB9bc', 'title' => 'Database Sharding - Hussein Nasser', 'type' => 'video'],
                    ['url' => 'https://www.mongodb.com/resources/products/capabilities/database-sharding-explained', 'title' => 'Database Sharding Explained', 'type' => 'article'],
                ],
            ],

            // Day 8: Message Queues
            [
                'title' => 'Message Queues & Async Processing',
                'description' => 'Understand message queues, pub/sub patterns, and asynchronous processing with tools like RabbitMQ, Kafka.',
                'estimated_time_minutes' => 90,
                'task_type' => 'reading',
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=oUJbuFMyBDk', 'title' => 'Message Queues Explained - IBM', 'type' => 'video'],
                    ['url' => 'https://www.youtube.com/watch?v=Ch5VhJzaoaI', 'title' => 'Apache Kafka in 5 Minutes', 'type' => 'video'],
                    ['url' => 'https://kafka.apache.org/intro', 'title' => 'Apache Kafka Introduction', 'type' => 'article'],
                ],
            ],

            // Day 9: Microservices Architecture
            [
                'title' => 'Microservices vs Monolith',
                'description' => 'Compare microservices and monolithic architectures, understand service boundaries and communication patterns.',
                'estimated_time_minutes' => 100,
                'task_type' => 'reading',
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=qYhRvH9tJKw', 'title' => 'Microservices Explained - TechWorld with Nana', 'type' => 'video'],
                    ['url' => 'https://www.youtube.com/watch?v=j6ow-UemzBc', 'title' => 'Microservices in 100 Seconds - Fireship', 'type' => 'video'],
                    ['url' => 'https://martinfowler.com/articles/microservices.html', 'title' => 'Microservices Guide - Martin Fowler', 'type' => 'article'],
                ],
            ],

            // Day 10: API Design Best Practices
            [
                'title' => 'RESTful API Design',
                'description' => 'Learn REST principles, API versioning, pagination, rate limiting, and best practices for API design.',
                'estimated_time_minutes' => 90,
                'task_type' => 'reading',
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=0oXYLzuucwE', 'title' => 'REST API Best Practices - freeCodeCamp', 'type' => 'video'],
                    ['url' => 'https://www.youtube.com/watch?v=lsMQRaeKNDk', 'title' => 'REST API Design - ByteByteGo', 'type' => 'video'],
                    ['url' => 'https://restfulapi.net/', 'title' => 'RESTful API Tutorial', 'type' => 'article'],
                ],
            ],

            // Day 11: CDN & Static Assets
            [
                'title' => 'Content Delivery Networks (CDN)',
                'description' => 'Understand how CDNs work, edge caching, and strategies for serving static assets efficiently.',
                'estimated_time_minutes' => 80,
                'task_type' => 'reading',
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=Bsq5cKkS33I', 'title' => 'What is a CDN? - Cloudflare', 'type' => 'video'],
                    ['url' => 'https://www.youtube.com/watch?v=6DXEPcXKQNY', 'title' => 'CDN Explained - ByteByteGo', 'type' => 'video'],
                    ['url' => 'https://www.cloudflare.com/learning/cdn/what-is-a-cdn/', 'title' => 'CDN Learning Center', 'type' => 'article'],
                ],
            ],

            // Day 12: Rate Limiting & Throttling
            [
                'title' => 'Rate Limiting Strategies',
                'description' => 'Learn about rate limiting algorithms (Token Bucket, Leaky Bucket), API throttling, and DDoS protection.',
                'estimated_time_minutes' => 90,
                'task_type' => 'reading',
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=FU4WlwfS3G0', 'title' => 'Rate Limiting Algorithms - ByteByteGo', 'type' => 'video'],
                    ['url' => 'https://www.youtube.com/watch?v=mhUQe4BKZXs', 'title' => 'Rate Limiting System Design', 'type' => 'video'],
                    ['url' => 'https://stripe.com/blog/rate-limiters', 'title' => 'Scaling Rate Limiters - Stripe', 'type' => 'article'],
                ],
            ],

            // Day 13: Authentication & Security
            [
                'title' => 'Authentication & Authorization at Scale',
                'description' => 'Understand JWT, OAuth 2.0, session management, and security best practices for distributed systems.',
                'estimated_time_minutes' => 100,
                'task_type' => 'reading',
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=926mknSW9Lo', 'title' => 'JWT in 100 Seconds - Fireship', 'type' => 'video'],
                    ['url' => 'https://www.youtube.com/watch?v=996OiexHze0', 'title' => 'OAuth 2.0 Explained - OktaDev', 'type' => 'video'],
                    ['url' => 'https://auth0.com/intro-to-iam', 'title' => 'Introduction to IAM - Auth0', 'type' => 'article'],
                ],
            ],

            // Day 14: Monitoring & Observability
            [
                'title' => 'Monitoring, Logging & Metrics',
                'description' => 'Learn about application monitoring, distributed tracing, logging strategies, and observability tools.',
                'estimated_time_minutes' => 90,
                'task_type' => 'reading',
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=W_7MaW_BLkQ', 'title' => 'Observability vs Monitoring - IBM', 'type' => 'video'],
                    ['url' => 'https://www.youtube.com/watch?v=r8UvWSX3KA8', 'title' => 'Distributed Tracing Explained - Honeycomb', 'type' => 'video'],
                    ['url' => 'https://prometheus.io/docs/introduction/overview/', 'title' => 'Prometheus Monitoring Overview', 'type' => 'article'],
                ],
            ],

            // Day 15: Consistency & Consensus
            [
                'title' => 'Distributed Consensus Algorithms',
                'description' => 'Understand Paxos, Raft, eventual consistency, and strong consistency in distributed systems.',
                'estimated_time_minutes' => 100,
                'task_type' => 'reading',
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=s8JqcZtvnsM', 'title' => 'Raft Consensus Algorithm', 'type' => 'video'],
                    ['url' => 'https://www.youtube.com/watch?v=JEpsBg0AO6o', 'title' => 'Distributed Systems - Martin Kleppmann', 'type' => 'video'],
                    ['url' => 'https://raft.github.io/', 'title' => 'Raft Visualization & Guide', 'type' => 'article'],
                ],
            ],

            // Day 16: Design URL Shortener
            [
                'title' => 'System Design: URL Shortener',
                'description' => 'Design a URL shortening service like bit.ly. Consider scalability, database design, and unique ID generation.',
                'estimated_time_minutes' => 120,
                'task_type' => 'project',
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=fMZMm_0ZhK4', 'title' => 'Design TinyURL - Gaurav Sen', 'type' => 'video'],
                    ['url' => 'https://www.youtube.com/watch?v=JQDHz72OA3c', 'title' => 'URL Shortener System Design - ByteByteGo', 'type' => 'video'],
                    ['url' => 'https://github.com/donnemartin/system-design-primer#design-pastebin-com', 'title' => 'URL Shortener Design Guide', 'type' => 'article'],
                ],
            ],

            // Day 17: Design Social Media Feed
            [
                'title' => 'System Design: Social Media News Feed',
                'description' => 'Design a news feed system like Twitter or Facebook. Consider fan-out strategies and real-time updates.',
                'estimated_time_minutes' => 120,
                'task_type' => 'project',
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=QmX2NPkJTKg', 'title' => 'Design Instagram - Gaurav Sen', 'type' => 'video'],
                    ['url' => 'https://www.youtube.com/watch?v=o5n85GRKuzk', 'title' => 'Design Twitter Feed - ByteByteGo', 'type' => 'video'],
                    ['url' => 'https://github.com/donnemartin/system-design-primer#design-the-twitter-timeline-and-search', 'title' => 'Twitter Design Guide', 'type' => 'article'],
                ],
            ],

            // Day 18: Design Chat Application
            [
                'title' => 'System Design: Real-time Chat System',
                'description' => 'Design a messaging system like WhatsApp or Slack. Consider WebSockets, message delivery, and read receipts.',
                'estimated_time_minutes' => 120,
                'task_type' => 'project',
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=vvhC64hQZMk', 'title' => 'Design WhatsApp - Gaurav Sen', 'type' => 'video'],
                    ['url' => 'https://www.youtube.com/watch?v=RjQjbJ2UJDg', 'title' => 'Design Messenger - ByteByteGo', 'type' => 'video'],
                    ['url' => 'https://github.com/donnemartin/system-design-primer#design-a-web-crawler', 'title' => 'Chat System Design Patterns', 'type' => 'article'],
                ],
            ],

            // Day 19: Design Video Streaming
            [
                'title' => 'System Design: Video Streaming Platform',
                'description' => 'Design a video streaming service like YouTube or Netflix. Consider video encoding, CDN, and adaptive streaming.',
                'estimated_time_minutes' => 120,
                'task_type' => 'project',
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=psQzyFfsUGU', 'title' => 'Design YouTube - Gaurav Sen', 'type' => 'video'],
                    ['url' => 'https://www.youtube.com/watch?v=lYoSd2WCJTo', 'title' => 'Design Netflix - ByteByteGo', 'type' => 'video'],
                    ['url' => 'https://netflixtechblog.com/', 'title' => 'Netflix Tech Blog', 'type' => 'article'],
                ],
            ],

            // Day 20: Design E-commerce Platform
            [
                'title' => 'System Design: E-commerce Platform',
                'description' => 'Design an e-commerce system like Amazon. Consider inventory management, payment processing, and order fulfillment.',
                'estimated_time_minutes' => 120,
                'task_type' => 'project',
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=EpASu_1dUdE', 'title' => 'Design Amazon - Gaurav Sen', 'type' => 'video'],
                    ['url' => 'https://www.youtube.com/watch?v=bUHFg8CZFws', 'title' => 'E-commerce System Design - Tech Dummies', 'type' => 'video'],
                    ['url' => 'https://github.com/donnemartin/system-design-primer#system-design-interview-questions-with-solutions', 'title' => 'E-commerce Design Patterns', 'type' => 'article'],
                ],
            ],
        ];

        $dayNumber = 1;
        foreach ($tasks as $taskData) {
            Task::create(array_merge($taskData, [
                'roadmap_id' => $roadmap->id,
                'day_number' => $dayNumber++,
                'order' => 1,
                'category' => 'System Design',
                'difficulty_level' => 'advanced',
                'learning_objectives' => [],
                'skills_gained' => ['System Design', 'Scalability', 'Architecture', 'Distributed Systems'],
                'tags' => ['system-design', 'architecture', 'scalability', 'distributed-systems'],
                'success_criteria' => [],
                'has_code_submission' => false,
                'has_quality_rating' => true,
            ]));
        }
    }
}
