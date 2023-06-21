<?php

declare(strict_types=1);

namespace App\Services\TagsExtractor\Adapters;

use Exception;
use Illuminate\Support\Facades\Log;
use Phpml\FeatureExtraction\TfIdfTransformer;
use Phpml\FeatureExtraction\TokenCountVectorizer;
use Phpml\Tokenization\WhitespaceTokenizer;

class PhpmlAdapter implements TagsExtractorLibraryInterface
{

  public function getResult(string $text, array $stopWords): array
  {
    $text = [$text];

    // Créer un vecteur de caractéristiques : Convertissez le texte en un vecteur de caractéristiques qui représente les mots présents dans le text
    $vectorizer = new TokenCountVectorizer(new WhitespaceTokenizer());
    // Build the dictionary.
    $vectorizer->fit($text);
    $vectorizer->transform($text);

    try {
      // Appliquer une méthode d'extraction des mots-clés : Une fois que vous avez le vecteur de caractéristiques,
      // vous pouvez appliquer une méthode d'extraction des mots-clés.
      //Par exemple, vous pouvez utiliser l'algorithme TF-IDF (Term Frequency-Inverse Document Frequency).
      $transformer = new TfIdfTransformer($text);
      $transformer->transform($text);
      $vocabulary = $vectorizer->getVocabulary();
      $response = array_diff($vocabulary, $stopWords);
    } catch (Exception $e) {
      Log::error('Error when trying to extract text with PHP-ML');
      throw new Exception($e->getMessage());
    }

    return $response;
  }
}
