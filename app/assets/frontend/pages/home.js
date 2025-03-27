export const fill_topics = () => {
  let quotes = document.find_all("[content] [quote]");
  let random_topics_container = document.querySelector("[random-topics]");
  let random_topics = random_topics_container.find_all("[topic]");

  let pointer = 0;
  let current_random_topic = 0;

  $.each(quotes, (i, quote) => {
    if (random_topics.length < 1) return;

    if (pointer === 9) {
      let $topic = $(random_topics[current_random_topic]);

      $(quote).after($topic);

      current_random_topic++;
      pointer = 0;
    } else pointer++;
  });
};
