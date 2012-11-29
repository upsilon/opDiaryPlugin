function runTests(apiBase, apiKey) {
  QUnit.moduleStart(function(details) {
    $.ajax(apiBase + 'test/setup.json?force=1&target=opDiaryPlugin', { async: false });
  });

  module('diary/search.json');

  asyncTest('should return entries', 3, function() {
    $.getJSON(apiBase + 'diary/search.json',
    {
      apiKey: apiKey['me'],
      format: 'mini'
    },
    function(data){
      equal(data.status, 'success', 'should return status code "success"');
      equal(data.data.length, 15, 'should return 15 articles');
      equal(data.next, 2, 'should return next page number 2 ');

      start();
    });
  });

  asyncTest('should return next page entries', 3, function() {
    $.getJSON(apiBase + 'diary/search.json',
    {
      apiKey: apiKey['me'],
      format: 'mini',
      page: 2
    },
    function(data){
      equal(data.status, 'success', 'should return status code "success"');
      equal(data.data.length, 15, 'should return 15 articles');
      equal(data.next, 3, 'should return next page number 3 ');

      start();
    });
  });

  asyncTest('fetch one diary entry', 5, function() {
    $.getJSON(apiBase + 'diary/search.json',
    {
      apiKey: apiKey['me'],
      id: 1
    },
    function(data){
      equal(data.status, 'success', 'should return status code "success"');

      equal(data.data.id, 1, 'should return id 1');
      equal(data.data.images.length, 1, 'should have 1 images');
      equal(data.data.next, "4", 'should have next field');
      equal(data.data.prev, null, 'should not have prev field');

      start();
    });
  });

  module('diary/post.json');

  asyncTest('should be able to post a new diary entry', 7, function() {
    var title = 'テストタイトル';
    var body = 'テスト本文';
    var publicFlag = 1; // 全員に公開 (PluginDiaryTable::PUBLIC_FLAG_SNS)

    $.getJSON(apiBase + 'diary/post.json',
    {
      apiKey: apiKey['me'],
      title: title,
      body: body,
      public_flag: publicFlag
    },
    function(data) {
      equal(data.status, 'success', 'should return status code "success"');

      ok(data.data.id, 'should have id');
      ok(data.data.member, 'should have member');
      equal(data.data.title, title, 'should have the same title posted');
      equal(data.data.body, body, 'should have the same body posted');
      equal(data.data.public_flag, publicFlag, 'should have the same publid flag posted');
      ok(data.data.created_at, 'should have the date posted');

      start();
    });
  });

  test('should return error when the title is empty', 2, function() {
    var body = 'テスト本文';
    var publicFlag = 1; // 全員に公開 (PluginDiaryTable::PUBLIC_FLAG_SNS)

    stop(2);

    $.getJSON(apiBase + 'diary/post.json',
    {
      apiKey: apiKey['me'],
      title: '',
      body: body,
      public_flag: publicFlag
    })
    .complete(function(jqXHR){
      equal(jqXHR.status, 400);
      start(1);
    });

    $.getJSON(apiBase + 'diary/post.json',
    {
      apiKey: apiKey['me'],
      body: body,
      public_flag: publicFlag
    })
    .complete(function(jqXHR){
      equal(jqXHR.status, 400);
      start(1);
    });
  });

  test('should return error when the body is empty', 2, function() {
    var title = 'テストタイトル';
    var publicFlag = 1; // 全員に公開 (PluginDiaryTable::PUBLIC_FLAG_SNS)

    stop(2);

    $.getJSON(apiBase + 'diary/post.json',
    {
      apiKey: apiKey['me'],
      title: title,
      body: '',
      public_flag: publicFlag
    })
    .complete(function(jqXHR){
      equal(jqXHR.status, 400);
      start(1);
    });

    $.getJSON(apiBase + 'diary/post.json',
    {
      apiKey: apiKey['me'],
      title: title,
      public_flag: publicFlag
    })
    .complete(function(jqXHR){
      equal(jqXHR.status, 400);
      start(1);
    });
  });

  test('should return error when the public flag is empty', 2, function() {
    var title = 'テストタイトル';
    var body = 'テスト本文';

    stop(2);

    $.getJSON(apiBase + 'diary/post.json',
    {
      apiKey: apiKey['me'],
      title: title,
      body: body,
      public_flag: ''
    })
    .complete(function(jqXHR){
      equal(jqXHR.status, 400);
      start(1);
    });

    $.getJSON(apiBase + 'diary/post.json',
    {
      apiKey: apiKey['me'],
      title: title,
      body: body
    })
    .complete(function(jqXHR){
      equal(jqXHR.status, 400);
      start(1);
    });
  });

  asyncTest('should be able to edit a existing diary entry', 7, function() {
    var id = 1;
    var title = '編集後のテストタイトル' + +(new Date);
    var body = '編集後のテスト本文' + +(new Date);
    var publicFlag = 3; // 公開しない (PluginDiaryTable::PUBLIC_FLAG_PRIVATE)

    $.getJSON(apiBase + 'diary/post.json',
    {
      apiKey: apiKey['me'],
      id: id,
      title: title,
      body: body,
      public_flag: publicFlag
    },
    function(data) {
      equal(data.status, 'success', 'should return status code "success"');

      equal(data.data.id, id, 'should have the same id');
      ok(data.data.member, 'should have member info');
      equal(data.data.title, title, 'should have the same title posted');
      equal(data.data.body, body, 'should have the same body posted');
      equal(data.data.public_flag, publicFlag, 'should have the same publid flag posted');
      ok(data.data.created_at, 'should have the date posted');

      start();
    });
  });

  test('only my friends should be able to view my diary entry for friends', 2, function() {
    var title = '友人のみに公開するテストタイトル';
    var body = '友人のみに公開するテスト本文';
    var publicFlag = 2; // 友人のみに公開 (PluginDiaryTable::PUBLIC_FLAG_FRIEND)

    stop(2);

    $.getJSON(apiBase + 'diary/post.json',
    {
      apiKey: apiKey['me'],
      title: title,
      body: body,
      public_flag: publicFlag
    },
    function(postedData) {
      $.getJSON(apiBase + 'diary/search.json', { apiKey: apiKey['myFriend'], id: postedData.data.id }, function(data) {
        equal(data.data, postedData.data, 'my friends can read my entries limited tothem.');
        start(1);
      });

      $.getJSON(apiBase + 'diary/search.json', { apiKey: apiKey['notMyFriend'], id: postedData.data.id })
        .complete(function(jqXHR) {
          equal(jqXHR.status, 400);
          start(1);
        });
    });
  });

  test('only myself should be able to view my private diary entry', 2, function() {
    var title = '秘密のテストタイトル';
    var body = '秘密のテスト本文';
    var publicFlag = 3; // 公開しない (PluginDiaryTable::PUBLIC_FLAG_PRIVATE)

    stop(2);

    $.getJSON(apiBase + 'diary/post.json',
    {
      apiKey: apiKey['me'],
      title: title,
      body: body,
      public_flag: publicFlag
    },
    function(postedData) {
      $.getJSON(apiBase + 'diary/search.json', { apiKey: apiKey['myFriend'], id: postedData.data.id })
        .complete(function(jqXHR) {
          equal(jqXHR.status, 400);
          start(1);
        });

      $.getJSON(apiBase + 'diary/search.json', { apiKey: apiKey['notMyFriend'], id: postedData.data.id })
        .complete(function(jqXHR) {
          equal(jqXHR.status, 400);
          start(1);
        });
    });
  });

  asyncTest('存在しない日記の編集', 1, function() {
    $.getJSON(apiBase + 'diary/post.json',
    {
      apiKey: apiKey['me'],
      id: 0,
      title: '日記タイトル',
      body: '日記本文',
      public_flag: 2
    })
    .complete(function(jqXHR){
      equal(jqXHR.status, 400);
      start(1);
    });
  });

  asyncTest('自分以外の日記の編集', 1, function() {
    $.getJSON(apiBase + 'diary/post.json',
    {
      apiKey: apiKey['me'],
      id: 3, // member5 の日記
      title: '日記タイトル',
      body: '日記本文',
      public_flag: 2
    })
    .complete(function(jqXHR){
      equal(jqXHR.status, 400);
      start(1);
    });
  });
}

runTests(
  '../../api.php/',
  {
    'me': 'dummyApiKey',            // member1
    'myFriend': 'dummyApiKey2',     // member2
    'notMyFriend': 'dummyApiKey5',  // member5
  }
);
