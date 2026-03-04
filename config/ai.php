<?php

return [
    /*
    |--------------------------------------------------------------------------
    | AI Provider
    |--------------------------------------------------------------------------
    |
    | The AI provider to use for content generation.
    | Supported: "openai", "groq", "gemini"
    |
    */
    'provider' => env('AI_PROVIDER', 'openai'),

    /*
    |--------------------------------------------------------------------------
    | Search Provider
    |--------------------------------------------------------------------------
    |
    | The search provider to use for getting real-time data.
    | Supported: "none", "perplexity", "tavily", "serper", "serpapi"
    |
    */
    'search_provider' => env('AI_SEARCH_PROVIDER', 'none'),

    /*
    |--------------------------------------------------------------------------
    | Perplexity AI
    |--------------------------------------------------------------------------
    |
    | Perplexity AI provides AI + web search in one API.
    | Get your API key from: https://www.perplexity.ai/settings/api
    |
    */
    'perplexity_api_key' => env('PERPLEXITY_API_KEY'),
    'perplexity_model' => env('PERPLEXITY_MODEL', 'sonar'),

    /*
    |--------------------------------------------------------------------------
    | Tavily AI
    |--------------------------------------------------------------------------
    |
    | Tavily is a search API optimized for AI agents.
    | Get your API key from: https://tavily.com
    |
    */
    'tavily_api_key' => env('TAVILY_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Serper API
    |--------------------------------------------------------------------------
    |
    | Serper provides Google Search API.
    | Get your API key from: https://serper.dev
    |
    */
    'serper_api_key' => env('SERPER_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | SerpAPI
    |--------------------------------------------------------------------------
    |
    | SerpAPI provides multiple search engines.
    | Get your API key from: https://serpapi.com
    |
    */
    'serpapi_key' => env('SERPAPI_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Groq
    |--------------------------------------------------------------------------
    |
    | Groq provides fast inference for open-source models.
    | Get your API key from: https://console.groq.com
    |
    */
    'groq_api_key' => env('GROQ_API_KEY'),
    'groq_model' => env('GROQ_MODEL', 'llama-3.3-70b-versatile'),

    /*
    |--------------------------------------------------------------------------
    | Google Gemini
    |--------------------------------------------------------------------------
    |
    | Google's Gemini AI models.
    | Get your API key from: https://makersuite.google.com/app/apikey
    |
    */
    'gemini_api_key' => env('GEMINI_API_KEY'),
    'gemini_model' => env('GEMINI_MODEL', 'gemini-pro'),
];
